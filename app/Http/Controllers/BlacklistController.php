<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//use App\Models\Blacklist;
//use App\Models\JobMonitor;
//use App\Jobs\ImportBlacklistJob;

class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $customer = $request->user()->customer;

        if (!$customer->can('read', new Blacklist())) {
            return $this->notAuthorized();
        }

        $blacklists = $this->search($request);

        return view('blacklists.index', [
            'blacklists' => $blacklists,
        ]);
    }

    /**
     * Search items.
     *
     * @param mixed $request
     */
    public function search($request)
    {
        $request->merge(['customer_id' => $request->user()->customer->id]);
        $blacklists = Blacklist::search($request);

        return $blacklists;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listing(Request $request)
    {
        if (!$request->user()->customer->can('read', new Blacklist())) {
            return $this->notAuthorized();
        }

        $blacklists = $this->search($request)->paginate($request->per_page);

        return view('blacklists._list', [
            'blacklists' => $blacklists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $blacklist = new Blacklist([
            'signing_enabled' => true,
        ]);
        $blacklist->fill($request->old());

        // authorize
        if (!$request->user()->customer->can('create', $blacklist)) {
            return $this->notAuthorized();
        }

        return view('blacklists.create', [
            'blacklist' => $blacklist,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Get current user
        $current_user = $request->user();
        $blacklist = new Blacklist();

        // authorize
        if (!$request->user()->customer->can('create', $blacklist)) {
            return $this->notAuthorized();
        }

        // save posted data
        if ($request->isMethod('post')) {
            $this->validate($request, Blacklist::rules());

            // Save current user info
            $blacklist->fill($request->all());
            $blacklist->customer_id = $request->user()->customer->id;
            $blacklist->status = 'active';

            if ($blacklist->save()) {
                // Log
                $blacklist->log('created', $request->user()->customer);

                $request->session()->flash('alert-success', trans('messages.blacklist.created'));

                return redirect()->action('BlacklistController@index');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function delete(Request $request)
    {
        if ($request->select_tool == 'all_items') {
            $blacklists = $this->search($request);
        } else {
            $blacklists = Blacklist::whereIn(
                'id',
                is_array($request->uids) ? $request->uids : explode(',', $request->uids)
            );
        }

        foreach ($blacklists->get() as $blacklist) {
            // authorize
            if ($request->user()->customer->can('delete', $blacklist)) {
                // Log
                $blacklist->delist($request->user()->customer);
                $blacklist->delete();
            }
        }

        // Redirect to my lists page
        echo trans('messages.blacklists.deleted');
    }

    /**
     * Start import process.
     *
     * @param Request $request
     * @return Response
     */
    public function import(Request $request)
    {
        $customer = $request->user()->customer;
        $job = $customer->importBlacklistJobs()->first();

        if ($job) {
            return view('blacklists.import', [
                'currentJobUid' => $job->uid,
                'cancelUrl' => action('BlacklistController@cancelImport', ['job_uid' => $job->uid]),
                'progressCheckUrl' => action('BlacklistController@importProgress', ['job_uid' => $job->uid]),
            ]);
        } else {
            return view('blacklists.import', [
                //
            ]);
        }
    }

    public function startImport(Request $request)
    {
        $customer = $request->user()->customer;

        if ($request->hasFile('file')) {
            $filepath = Blacklist::upload($request->file('file'));

            // Start system job
            $job = $customer->dispatchWithMonitor(new ImportBlacklistJob($filepath, $customer));

            return redirect()->action('BlacklistController@import');
        } else {
            throw new Exception('no upload file');
        }
    }

    /**
     * Check import proccessing.
     *
     * @param Request $request
     * @return Response
     */
    public function importProgress(Request $request)
    {
        $job = JobMonitor::findByUid($request->job_uid);

        if (is_null($job)) {
            throw new Exception(sprintf('Blacklist import job #%s does not exist', $request->job_uid));
        }

        $progress = $job->getJsonData();
        $progress['status'] = $job->status;
        $progress['error'] = $job->error;

        // Get progress updated by the import process and status of the final job monitor
        return response()->json($progress);
    }

    /**
     * Cancel importing job.
     *
     * @param Request $request
     * @return Response
     */
    public function cancelImport(Request $request)
    {
        $job = JobMonitor::findByUid($request->job_uid);
        if (is_null($job)) {
            throw new Exception(sprintf('Verification job #%s does not exist', $request->job_uid));
        }

        $job->cancel();

        return response()->json();
    }
}
