<?php

/**
 * TimePickerWidget class file.
 *
 * @author Radu Dumbrăveanu <vundicind@gmail.com>
 * @link https://github.com/vundicind/yii-pickadate/
 */
class TimePickerWidget extends CInputWidget {

    protected $baseScript = 'picker';

    /** @var string used for translation of months, week days etc. */
    public $language = null;

    /** @var boolean enable for languages that flow from right-to-left */
    public $rtl = false;

    /** @var array the pick time configuration options. */
    public $options = array();

    /** @var array the Javascript event handlers. */
    public $events = array();

    /** @var array the HTML attributes for the widget container. */
    public $htmlOptions = array();

    /** @var array additional js files to include. */
    public $scripts = array();

    /** @var array the embedded script configuration options. */
    public $embeddedScriptOptions = array();

    /**
     * Initializes the widget.
     */
    public function init() {
        // check if options parameter is a json string
        if (is_string($this->options)) {
            if (!$this->options = CJSON::decode($this->options)) {
                throw new CException('The options parameter is not valid JSON.');
            }
        }

        // merge options with default values
        $defaultOptions = array();
        $this->options = CMap::mergeArray($defaultOptions, $this->options);

        // merge options with Javascript events
        $normalizedEvents = array();
        foreach ($this->events as $name => $handler) {
            $normalizedEvents[$name] = new CJavaScriptExpression($handler);
        }
        $this->options = CMap::mergeArray($normalizedEvents, $this->options);

        // prepend pickadate scripts to the begining of the additional js files array
        if(!empty($this->language))
            array_unshift($this->scripts, "translations/{$this->language}");
        array_unshift($this->scripts, 'picker.time');
        array_unshift($this->scripts, $this->baseScript);

    }

    /**
     * Renders the widget.
     */
    public function run() {
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $id = $this->htmlOptions['id'] = $this->getId();
        }

        if($this->hasModel())
            echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textField((isset($this->htmlOptions['name']) ? $this->htmlOptions['name'] : $id ), $this->value, $this->htmlOptions);

        $jsOptions = CJavaScript::encode($this->options);

        $embeddedScript = "$('#{$id}').pickatime({$jsOptions});";

        $this->registerScripts(__CLASS__ . '#' . $id, $embeddedScript);
    }


    /**
     * Publishes and registers the necessary script files.
     *
     * @param string the id of the script to be inserted into the page
     * @param string the embedded script to be inserted into the page
     */
    protected function registerScripts($id, $embeddedScript) {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $basePath .= YII_DEBUG ? 'compressed' . DIRECTORY_SEPARATOR : '';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, -1, YII_DEBUG);

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        // register additional scripts
        foreach ($this->scripts as $script) {
            $cs->registerScriptFile("{$baseUrl}/{$script}.js", CClientScript::POS_HEAD);
        }

        // register embedded script
        $cs->registerScript($id, $embeddedScript, CClientScript::POS_LOAD);

        // register css
        if(isset($this->options['theme'])) {
            switch($this->options['theme']) {
                case 'default':
                    $cs->registerCssFile("{$baseUrl}/themes/default.css");
                    $cs->registerCssFile("{$baseUrl}/themes/default.time.css");
                    break;
                case 'classic':
                    $cs->registerCssFile("{$baseUrl}/themes/classic.css");
                    $cs->registerCssFile("{$baseUrl}/themes/classic.time.css");
                    break;
            }

        } else {
            $cs->registerCssFile("{$baseUrl}/themes/default.css");
            $cs->registerCssFile("{$baseUrl}/themes/default.time.css");
        }

        if($this->rtl)
            $cs->registerCssFile("{$baseUrl}/themes/rtl.css");
    }
}