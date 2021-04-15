<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Database\Eloquent\Builder;
use DB;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreBoard;

class BoardController extends Controller {
    protected $board;
    protected $bo_if;
    protected $ASCII_A = 65;  //	A의 아스키코드
    protected $param = Array();

    public function __construct(Request $req, Board $board) {
        $this->board = $board;
        $this->board->setTableName($req->bo_cd);
        $this->param['bo_cd'] = $req->bo_cd;
        cache(['board' => config('board.'.$req->bo_cd)?:['name'=> '일반 게시판', 'row'=>10, 'is_thumb'=>true]]);
        $this->param['bo_nm'] = cache('board')['name'];
        $this->param['row'] = cache('board')['row'];
        $this->param['is_thumb'] = cache('board')['is_thumb'];
        $this->param['upload_path'] = 'storage/board/'.$req->bo_cd;
    }
    public function index(Request $req) {
        // $bo = $this->board
        //         ->where('bo_group', 0)
        //         ->orderByRaw('bo_seq, bo_seq_cd');
        // $bo = $bo->paginate($this->param['row']);
        // $this->param['list'] = $bo;
        // return view("web.board.$bo_cd.index", $this->param);
// abort(500, 'We could not retrieve the users');
        // $boards = $this->board
        //         ->where('bo_group', 0)
        //         ->orderByRaw('bo_seq, bo_seq_cd')->get()->toArray();
        $bo = $this->board
                ->where('bo_group', 0)
                ->orderByRaw('bo_seq, bo_seq_cd');

        if ($req->filled('sch_txt')) {
/*            $orders = $orders->where(function($query) use ($params){
                        $query->SchOd_no($params['sch_text'])->orWhere(function (Builder $query) use ($params) {
                            $query->SchWriter(User::SchName($params['sch_text'])->pluck('id'));
                        })->orWhere(function (Builder $query) use ($params) {
                            $query->SchOd_addr($params['sch_text']);
                        })->orWhere(function (Builder $query) use ($params) {
                            $query->SchOd_hp($params['sch_text']);
                        });
                    });*/
            $sch_txt = trim($req->sch_txt);
            $bo = $bo->where(function (Builder $query) use ($sch_txt) {
                        $query->where('bo_subject', 'like', "%".$sch_txt."%")
                            ->orWhere('bo_content', 'like', "%".$sch_txt."%")
                            ->orWhere('bo_writer', 'like', "%".$sch_txt."%");
                    });
        }
        // echo_query($bo);
        $bo = $bo->paginate($this->param['row']);

        foreach ($bo as $key => $val) {
            if($val->created_at->format('Y')<now()->format('Y'))
                $val->bo_date = $val->created_at->format('y-m-d');
            elseif($val->created_at->format('Y-m-d')<now()->format('Y-m-d'))
                $val->bo_date = $val->created_at->format('m-d');
            else
                $val->bo_date = $val->created_at->format('H:i');
        }

        $this->param['board'] = $bo;

        // return view("layouts.app", $bo);
        return response()->json($this->param);

    }

        public function show(Request $req, $bo_cd, $bo_id) {
            $bo = $this->board->where('bo_id', $bo_id)->first();
            event(new BoardView($req, $bo));
            $this->param['bo'] = $bo;
            if(count($bo->fileInfo_bo)){
                foreach($bo->fileInfo_bo as $fi){
                    if(preg_match("/(jpg|png|gif|bmp|jpeg)/", $fi->type))
                        $this->param['img_file'][] = $fi;
                    else
                        $this->param['add_file'][] = $fi;
                }
            }
            $this->param['comment'] = $bo->getComment();
            return view("web.board.$bo_cd.show", $this->param);
        }

        public function create($bo_cd, $bo_papa_id=null) {
            $this->param['act_type'] = 'create';
            $this->param['bo_papa_id'] = $bo_papa_id;
            return view("web.board.$bo_cd.form", $this->param);
        }

        public function store(StoreBoard $req, $bo_cd) {
            if ($req->wri_type == 'comment')    $pieces = $this->co_reqImplant($req);
            else if ($req->wri_type == 'reply') $pieces = $this->re_reqImplant($req);
            else                                $pieces = ['bo_seq' => ($this->board->min('bo_seq'))-1];
            $pieces = Arr::collapse([$this->bo_reqImplant($req), $pieces]);
            $pieces = Arr::collapse([['created_id' => auth()->user()->id ], $pieces]);
            $bo_id = $this->board->insertGetId($pieces);    //  가공된 자료DB insert
            $this->fiKeySet($req, $bo_id);  //  업로드된 파일 게시판 키 입력
            if ($req->wri_type == 'comment') {
                $redirect = route('board.show', ['bo_cd'=>$bo_cd, 'bo_id'=>$pieces['bo_group']])."#comment_".$bo_id;
                event(new Point("comment", 'up'));
            } else {
                $redirect = route('board.show', ['bo_cd'=>$bo_cd, 'bo_id'=>$bo_id]);
                // event(new Point("board", 'up'));
            }
            return response()->json("success", 200);
    	   	// return redirect($redirect);
        }

        public function re_reqImplant($req) {
            $papa = $this->board->where('bo_id', $req->bo_papa_id)->first();
            $sibling_cnt = $this->board->where([ ['bo_seq', $papa->bo_seq], ['bo_seq_cd', 'like', $papa->bo_seq_cd.'%'] ])
                                ->whereRaw('LENGTH(bo_seq_cd) = ?', (strlen($papa->bo_seq_cd))+1)
                                ->count();
            $bo_seq_cd = $papa->bo_seq_cd.chr($this->ASCII_A+$sibling_cnt);
            return [    'bo_seq'    => $papa->bo_seq,
                        'bo_seq_cd' => $bo_seq_cd ];
        }

        public function co_reqImplant($req) {
            $papa = $this->board->where('bo_id', $req->bo_papa_id)->first();
            if ($papa->bo_group == 0) {
                $bo_co_seq = $this->board->where([['bo_group', $req->bo_papa_id], ['bo_co_seq_cd', 'A']])->max('bo_co_seq');
                $bo_co_seq += 1;
                $bo_group =  $papa->bo_id;
            } else {
                $bo_co_seq = $papa->bo_co_seq;
                $bo_group =  $papa->bo_group;
            }
            $sibling_cnt = $this->board->where([['bo_group', $papa->bo_group], ['bo_co_seq', $papa->bo_co_seq]])
                                ->whereRaw('LENGTH(bo_co_seq_cd) = ?', (strlen($papa->bo_co_seq_cd))+1)
                                ->count();
            $bo_co_seq_cd = $papa->bo_co_seq_cd.chr($this->ASCII_A+$sibling_cnt);
            return [    'bo_seq'       => $papa->bo_seq,
                        'bo_group'     => $bo_group,
                        'bo_co_seq'    => $bo_co_seq,
                        'bo_co_seq_cd' => $bo_co_seq_cd ];
        }

        public function edit($bo_cd, $bo_id) {
            $this->param['act_type'] = 'edit';
            $bo = $this->board->where('bo_id', $bo_id)->first();
            $this->param['bo'] = $bo;
            $this->param['add_file'] = $bo->fileInfo_bo()->get();
            return view("web.board.$bo_cd.form", $this->param);
        }

        public function update(Request $req, $bo_cd, $bo_id) {
            $pieces = ['updated_id' => auth()->user()->id, 'updated_at' => now()];
            $pieces = Arr::collapse([$this->bo_reqImplant($req), $pieces]);
            $this->board->where('bo_id', $bo_id)->update($pieces);
            $this->fiKeySet($req, $bo_id);

            if ($req->wri_type == 'comment')    $url = route('board.show', ['bo_cd'=>$bo_cd, 'bo_id'=>$req->bo_papa_id])."#comment_".$bo_id;
            else                                $url = route('board.show', ['bo_cd'=>$bo_cd, 'bo_id'=>$bo_id]);
            return redirect($url);
        }

        public function destroy($bo_cd, $bo_id) {
            $bo = $this->board->where('bo_id', $bo_id)->first();
            if ($bo->bo_seq_cd)         $boType = "reply";
            else if ($bo->bo_co_seq_cd) $boType = "comment";
            else                        $boType = "board";

            $msg = null;
            $redirect_url = route('board.index', $bo_cd);
            if ($boType == 'comment') {
                $co_cnt = $this->board->where([ ['bo_group', $bo->bo_group],
                                                ['bo_co_seq', $bo->bo_co_seq],
                                                ['bo_co_seq_cd', '<>', $bo->bo_co_seq_cd],
                                                ['bo_co_seq_cd', 'like', $bo->bo_co_seq_cd.'%']])->count();
                if ($co_cnt >= cache('board')['noDelco'])
                    $msg = "댓글이 ".cache('board')['noDelco']."개 이상 있습니다.";
                $redirect_url = route('board.show', ['bo_cd'=>$bo_cd, 'bo_id'=>$bo->bo_group]);
            } else if ($boType == 'reply') {
                $co_cnt = $this->board->where('bo_group', $bo_id)->count();
                if ($co_cnt >= cache('board')['noDelco'])
                    $msg = "댓글이 ".cache('board')['noDelco']."개 이상 있습니다.";
                $re_cnt = $this->board->where([ ['bo_seq', $bo->bo_seq],
                                                ['bo_seq_cd', '<>', $bo->bo_seq_cd],
                                                ['bo_seq_cd', 'like', $bo->bo_seq_cd.'%']])->count();
                if ($re_cnt >= cache('board')['noDelRe'])
                    $msg = "답글이 ".cache('board')['noDelRe']."개 이상 있습니다.";
            } else {
                $co_cnt = $this->board->where('bo_group', $bo_id)->count();
                if ($co_cnt >= cache('board')['noDelco'])
                    $msg = "댓글이 ".cache('board')['noDelco']."개 이상 있습니다.";
                $re_cnt = $this->board->where('bo_seq', $bo->bo_seq)->whereNotNull('bo_seq_cd')->count();
                if ($re_cnt >= cache('board')['noDelRe'])
                    $msg = "답글이 ".cache('board')['noDelRe']."개 이상 있습니다.";
            }
            if ($msg)
                abort(500, $msg);
            else {
                $this->board->where('bo_id', $bo_id)->delete();
                return redirect($redirect_url);
            }
        }

        public function bo_reqImplant($req) {
            return [
                'bo_writer'  => auth()->user()->name,
                'bo_subject' => $req->filled('bo_subject') ? $req->bo_subject : '',
                'bo_content' => $req->filled('bo_content') ? $req->bo_content : '',
                'ip'         => $req->ip()
            ];
        }

        public function fiKeySet($req, $bo_id) {
            if ($req->filled('fi_id')){
    			foreach ($req->fi_id as $fi_id) {
    				$finfo = FileInfo::findOrFail($fi_id);
    				$finfo->fi_key	= $bo_id;
    				$finfo->save();
    			}
    		}
        }

        public function goodBad($bo_cd, $bo_id, $type) {
            $good = DB::table('board_good')->where([    ['bg_table', $bo_cd],
                                                        ['bg_bo_id', $bo_id],
                                                        ['created_id', auth()->user()->id]  ])->first();
            // dump($good);
            if ($type == 'GOOD' || $type == 'BAD') {
                if ($good) {
                    return response()->json(($good->bg_type == $type)?'already':'reverse', 200);
                } else {
                    $this->board->where('bo_id', $bo_id)->increment(($type=='GOOD')?'bo_good':'bo_bad');
                    DB::table('board_good')->insert([   'bg_table' => $bo_cd,
                                                        'bg_bo_id' => $bo_id,
                                                        'bg_type' => ($type=='GOOD')?'GOOD':'BAD',
                                                        'created_id' => auth()->user()->id ]);
                    event(new Point("goodbad", 'up'));
                    return response()->json("success", 200);
                }
            } else if ($type == 'already' || $type == 'reverse') {
                $this->board->where('bo_id', $bo_id)->decrement(($good->bg_type=='GOOD')?'bo_good':'bo_bad');
                if ($type == 'reverse'){
                    $this->board->where('bo_id', $bo_id)->increment(($good->bg_type=='GOOD')?'bo_bad':'bo_good');
                    DB::table('board_good')
                        ->where([ ['bg_table', $bo_cd], ['bg_bo_id', $bo_id], ['created_id', auth()->user()->id] ])
                        ->update( ['bg_type' => ($good->bg_type=='GOOD')?'BAD':'GOOD'] );
                } else {
                    DB::table('board_good')
                        ->where([ ['bg_table', $bo_cd], ['bg_bo_id', $bo_id], ['created_id', auth()->user()->id] ])
                        ->delete();
                    event(new Point("goodbad", 'dn'));
                }


            }
        }
    }
