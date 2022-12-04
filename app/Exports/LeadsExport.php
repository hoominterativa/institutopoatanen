<?php

namespace App\Exports;

use App\Models\ContactLead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LeadsExport implements FromCollection
{
    protected $contactLeads;

    public function __construct($contactLeads)
    {
        $this->contactLeads = $contactLeads;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $contactLeadsFilter = [];
        foreach ($this->contactLeads as $contactLead) {
            $info = [];
            unset($contactLead->json->target_lead);
            foreach ($contactLead->json as $key => $value) {
                if($value->type<>'file'){
                    if(isset($value->value)){
                        $info = array_merge($info, [$value->value]);
                    }
                }
            }
            $contactLeadsFilter = array_merge($contactLeadsFilter, [$info]);
        }

        return new Collection($contactLeadsFilter);
    }
}
