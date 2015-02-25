<?php

/**
 * Allows user to pick a Font Awesome Icon
 *
 * @author  Darren-Lee Joseph <darrenleejoseph@gmail.com>
 * @package  silverstripe-fontawesome-iconpickerfield
 */
class FontAwesomeIconPickerField extends TextField {

    public function __construct($name, $title = null, $value = '', $maxLength = null, $form = null){
        parent::__construct($name, $title, $value, $maxLength, $form);
    }

    public function Field($properties = array()) {
        $this->addExtraClass('form-control icp icp-auto');
        Requirements::css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
        Requirements::css('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
        Requirements::css(FONTAWESOMEICONPICKER_DIR . '/code/thirdparty/fontawesome-iconpicker-1.0.0/dist/css/fontawesome-iconpicker.min.css');

        Requirements::set_force_js_to_bottom(true);
        Requirements::javascript(FONTAWESOMEICONPICKER_DIR . '/code/thirdparty/fontawesome-iconpicker-1.0.0/dist/js/fontawesome-iconpicker.js');

        Requirements::customScript(<<<JS
            jQuery(function() {
                jQuery('.icp-auto').iconpicker();
            });
JS
    );

        return parent::Field($properties);
    }

    /**
     * Override the type to get the proper class name on the field
     * "text" is needed here to render the form field as a normal text-field
     * @see FormField::Type()
     */
    public function Type(){
        return 'text';
    }

    /**
     * Ensure the value is a valid Font Awesome value beginning with 'fa-'
     * @see FormField::validate()
     */
    public function validate($validator)
    {
        if(!empty ($this->value) && !preg_match('/^fa-[a-z]+/', $this->value))
        {
            $validator->validationError(
                $this->name,
                _t('FontAwesomeIconPickerField.VALIDFONT', 'Please enter a valid Font Awesome font name format.'),
                'validation',
                false
            );
            return false;
        }
        return true;
    }



}