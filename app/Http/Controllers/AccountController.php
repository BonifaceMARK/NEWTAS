<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AccountsImport;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AccountController extends Controller
{

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls',
        'campaign' => 'required|string'
    ]);

    try {
        Log::channel('accounts_import')->info('Import started', [
            'campaign' => $request->campaign,
            'filename' => $request->file('file')->getClientOriginalName(),
            'user'     => auth()->user()->name ?? 'system',
        ]);

        Excel::import(new AccountsImport($request->campaign), $request->file('file'));

        Log::channel('accounts_import')->info('Import completed successfully', [
            'campaign' => $request->campaign,
        ]);

        return redirect()->route('accounts.index')
            ->with('success', 'Bulk accounts imported successfully into campaign: ' . $request->campaign);
    } catch (\Exception $e) {
        Log::channel('accounts_import')->error('Import failed', [
            'campaign' => $request->campaign,
            'error'    => $e->getMessage(),
            'trace'    => $e->getTraceAsString(),
        ]);

        return redirect()->route('accounts.index')
            ->with('error', 'Import failed: ' . $e->getMessage());
    }
}public function index(Request $request)
{
    $limit = $request->input('limit', 15);

    $query = Account::query();

    if ($request->filled('campaign')) {
        $query->where('campaign', $request->campaign);
    }

    $query->orderBy('created_at', 'desc');

    if ($limit === 'all') {
        $accounts = $query->get();
    } else {
        $accounts = $query->take((int)$limit)->get();
    }

    $totalAccounts = Account::count();

    $activeAccounts = Account::where('status', 'Active')->count();

    $inactiveAccounts = Account::where('status', '!=', 'Active')->count();

    $totalCampaigns = Account::distinct('campaign')->count('campaign');

    return view('accounts.index', compact(
        'accounts',
        'limit',
        'totalAccounts',
        'activeAccounts',
        'inactiveAccounts',
        'totalCampaigns'
    ));
}

    public function show($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.show', compact('account'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'fullname'      => 'nullable|string|max:150',
        'nas_username'  => 'nullable|string|max:100',
        'nas_password'  => 'nullable|string|max:255',
        'ad_username'   => 'nullable|string|max:100',
        'ad_password'   => 'nullable|string|max:255',
        'ad_domain'     => 'nullable|string|max:100',
        'ad_email'      => 'nullable|email|max:150',
        'sip_extension' => 'nullable|string|max:50',
        'sip_password'  => 'nullable|string|max:255',
        'agent_number'  => 'nullable|string|max:50|unique:tbl_accounts,agent_number',
        'sip_server_ip' => 'nullable|string|max:100',
        'campaign'      => 'nullable|string|max:100',
        'position'      => 'nullable|string|max:100',
        'level'         => 'nullable|string|max:50',
        'team'          => 'nullable|string|max:100',
        'status'        => 'nullable|in:Active,Inactive,Disabled,Pending',
        'remarks'       => 'nullable|string',
    ]);

    Account::create($validated);

    return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
}

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'nas_username' => 'required|string|max:100',
            'nas_password' => 'required|string|max:255',
            'ad_username' => 'required|string|max:100',
            'ad_password' => 'required|string|max:255',
            'ad_domain'   => 'nullable|string|max:100',
            'ad_email'    => 'nullable|email|max:150',
            'sip_extension' => 'required|string|max:50',
            'sip_password'  => 'required|string|max:255',
            'agent_number'  => 'required|string|max:50|unique:tbl_accounts,agent_number,' . $account->id,
            'sip_server_ip' => 'nullable|string|max:100',
            'campaign'      => 'required|string|max:100',
            'status'        => 'required|in:Active,Inactive,Disabled,Pending',
            'remarks'       => 'nullable|string',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
