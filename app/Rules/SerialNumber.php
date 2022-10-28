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
        $original_sn_array = str_split($value);
        $tamplate_sn = EquipmentType::find($this->data['equipment_type_id'])->mask;
        $tamplate_sn_array = str_split($tamplate_sn);
        
        foreach($original_sn_array as $key=>$char){
            // $tamplate_sn_array[$key]
            switch ($tamplate_sn_array[$key]) {
                case 'N':
                    $pattern = '/^[0-9]+$/i';
                    break;
                case 'A':
                    $pattern = '/^[A-Z]+$/i';
                    break;
                case 'a':
                    $pattern = '/^[a-z]+$/i';
                    break;
                case 'X':
                    $pattern = '/^[A-Z9-0]+$/i';
                    break;
                case 'X':
                    $pattern = '/^[-_@]+$/i';
                    break;
            }
                // var_dump($tamplate_sn_array[$key]);
            if (preg_match($pattern,$char)){
                // var_dump(1);
            }else{
                $fail('The :attribute mask does not fit. Mask:'.$tamplate_sn);
            }

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
