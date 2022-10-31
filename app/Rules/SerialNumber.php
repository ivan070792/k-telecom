<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\DataAwareRule;

class SerialNumber implements InvokableRule, DataAwareRule
{
    protected $data = [];
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $tamplate_sn = EquipmentType::findOrFail($this->data['equipment_type_id'])->mask;
        $tamplate_sn_array = str_split($tamplate_sn);

        $sn_reg_ex = '/^';
        
        foreach($tamplate_sn_array as $char){
            switch ($char) {
                case 'N':
                    $sn_reg_ex .= '[0-9]';
                    break;
                case 'A':
                    $sn_reg_ex .= '[A-Z]';
                    break;
                case 'a':
                    $sn_reg_ex .= '[a-z]';
                    break;
                case 'X':
                    $sn_reg_ex .= '[A-Z0-9]';
                    break;
                case 'Z':
                    $sn_reg_ex .= '[-_@]';
                    break;
            }    
        }
        $sn_reg_ex .= '$/s';
        if (preg_match($sn_reg_ex, $value)){
                return true;
        }else{
            $fail('The :attribute mask does not fit. Mask:'.$tamplate_sn);
        }

    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data; // Возможно не нужно педедавать все данные, а только equipment_type_id
        return $this;
    }
}
