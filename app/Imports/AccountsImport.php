<?php
namespace App\Imports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountsImport implements ToModel, WithHeadingRow
{
    protected $campaign;

    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    public function model(array $row)
    {
        return new Account([
            'ad_username'   => $row['name'] ?? null,        // Excel NAME
            'nas_username'  => $row['nas'] ?? null,         // Excel NAS
            'nas_password'  => $row['password'] ?? null,    // Excel PASSWORD
            'remarks'       => $row['remarks'] ?? null,     // Excel REMARKS
            'status'        => strtoupper($row['remarks'] ?? 'Active'),
            'campaign'      => $this->campaign,             // ✅ dropdown value
            'ad_password'   => $row['password'] ?? null,
            'sip_extension' => null,
            'sip_password'  => null,
            'agent_number'  => null,
        ]);
    }
}
