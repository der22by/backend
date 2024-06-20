<?php
declare(strict_types=1);

namespace App\Http\Requests\ServiceMaster;

use App\Http\Requests\BaseRequest;
use App\Models\Service;
use App\Models\ServiceMasterPrice;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'discount'                      => 'numeric|min:0',
            'service_id'                    => ['required', 'int', Rule::exists('services', 'id')],
            'shop_id'                       => ['required', 'int', Rule::exists('shops', 'id')],
            'commission_fee'                => 'numeric|min:0',
            'price'                         => 'required|numeric|min:0',
            'interval'                      => 'required|numeric|min:0',
            'pause'                         => 'required|numeric|min:0',
            'type'                          => Rule::in(Service::TYPES),
            'active'                        => 'bool',
            'data'                          => 'array',
            'gender'                        => ['int', Rule::in(Service::GENDERS)],

            'pricing'                       => 'array',
            'pricing.*'                     => 'required|array',
            'pricing.*.duration'            => ['required', 'string', Rule::in(ServiceMasterPrice::DURATIONS)],
            'pricing.*.price_type'          => ['required', 'string', Rule::in(ServiceMasterPrice::PRICE_TYPES)],
            'pricing.*.price'               => 'required|numeric|min:0',

            'pricing.*.title'               => 'array',
            'pricing.*.title.*'             => 'required|string',

            'pricing.*.smart'               => 'array',
            'pricing.*.smart.*'             => 'required|array',

            'pricing.*.smart.*.from'        => 'required|date_format:H:i',
            'pricing.*.smart.*.to'          => 'required|date_format:H:i',
            'pricing.*.smart.*.type'        => ['required', Rule::in(ServiceMasterPrice::SMART_PRICE_TYPES)],
            'pricing.*.smart.*.value'       => 'required|numeric|min:0',
            'pricing.*.smart.*.value_type'  => ['required', Rule::in(ServiceMasterPrice::SMART_PRICE_VALUE_TYPES)],
        ];
    }
}
