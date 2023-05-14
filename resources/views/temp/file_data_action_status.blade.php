$user_type = Auth::user()->user_type;
                    if($user_type == 'admin'){
                        $btn = '
                        <div style="width:150px" class="row">
                        <form action="'.route('customer.delete',$row->id).'" method="Post">
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a type="submit" class="btn btn-danger btn-sm edit" href="'.route('file.delete' ,$row->id).'" title="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </form>
                        </div>';
                        return $btn;
                    }else{
                        if($row->status == 'Completed' || $row->status == 'Cancelled' || $user_type == 'lawyer' ){
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            ';
                            return $btn;
                        }else{
                            $btn = '
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            ';
                            return $btn;
                        }
                    }
                })
            