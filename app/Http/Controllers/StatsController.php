<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

class StatsController extends Controller {

    /**
     * @param
     */
    public function __construct() {
        // Add auth filter
        $this->middleware('auth.status');
    }

    /**
     * @param
     */
    public function dailySms(Request $request){
        // count sms activity per user
        $users = DB::table('sms_activities')
            ->join('users', 'users.id', '=', 'sms_activities.user_id')
            ->groupBy('sms_activities.user_id')
            ->select('users.name', DB::raw('count(*) as total'));

        // Test if date was submitted
        if($request->date) {
            $users = $users->whereRaw("date(txt_sms_activities.created_at) = '" . $request->date . "'");
        }
        $users = $users->get();

        // create datatable
        $lava = new Lavacharts();
        $reasons = $lava->DataTable();
        $reasons->addStringColumn('Users')
            ->addNumberColumn('Percent');

        foreach($users as $user) {
            $reasons->addRow(array($user->name, $user->total));
        }

        $piechart = $lava->PieChart('SMS')
            ->setOptions(array(
                'datatable' => $reasons,
                'title' => 'Daily SMS Count per User' . ($request->date?" (".$request->date.")":" (All time)"),
                'is3D' => true,
                'height' => 400,
                'width' => 600
            ));

        \Illuminate\Support\Facades\Request::flash();
        return view('stats.sms')->with('lava', $lava);


    }

}
