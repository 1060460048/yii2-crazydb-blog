<?php
namespace app\modules\admin\controllers;

use Yii;

use app\components\CMSUtils;
use app\components\XUtils;
use app\modules\admin\components\Controller;
use app\modules\admin\models\SettingForm;
use app\modules\admin\models\SeoForm;

/**
 * Default controller
 */
class ConfigController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Base Setting
     * 基本设置
     */
    public function actionSetting()
    {
        $setting = new SettingForm();
        $setting->load(CMSUtils::getSiteConfig('sys'), '');
        $setting->setOldAttributes($setting->attributes);
        $themes = array('[none]' => '不使用主题');
        $themes += XUtils::getThemeList();
        if ($setting->load(Yii::$app->request->post())) {
            if (!array_key_exists($setting->theme, $themes)) {
                $setting->theme = '[none]';
                $setting->addError('theme', '指定主题不存在！');
            } elseif ($setting->save('sys')) {
                Yii::$app->cache->set('config_sys', $setting->attributes);
            }
        }
        return $this->render('setting', ['model' => $setting, 'themes' => $themes]);
    }

    /**
     * 系统SEO设置
     */
    public function actionSeo()
    {
        $seo = new SeoForm();
        $seo->setAttributes(CMSUtils::getSiteConfig('seo'));
        $seo->setOldAttributes($seo->attributes);
        if ($seo->load(Yii::$app->request->post())) {
            if ($row = $seo->save('seo')) {
                Yii::$app->cache->set('config_seo', $seo->attributes);
            }
        }
        return $this->render('seo', array('model' => $seo));
    }

    /**
     * 系统Slider设置
     */
    public function actionSlider()
    {

    }

    /**
     * 系统缓存设置
     */
    public function actionCache()
    {

    }

}
