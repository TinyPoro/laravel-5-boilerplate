<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function getTimeAttribute(){
        $startTime = Carbon::parse($this->created_at);
        $now = Carbon::now();


        return $startTime->diffForHumans($now);
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.auth.news.show', $this).'" class="btn btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.auth.news.edit', $this).'" class="btn btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.auth.news.destroy', $this).'" data-method="delete" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a>';
    }

    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.auth.news.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.news_management.news.restore_user').'"></i></a>';
    }

    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="'.route('admin.auth.news.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.news_management.news.delete_permanently').'"></i></a>';
    }

    public function getActionButtonsAttribute(){
        if ($this->trashed()) {
            return '
				<div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
				  '.$this->restore_button.'
				  '.$this->delete_permanently_button.'
				</div>';
        }

        return '
    	<div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
		  '.$this->show_button.'
		  '.$this->edit_button.'
		  '.$this->delete_button.'
		</div>';
    }

    public function getDeletedAtColumn()
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    public function trashed()
    {
        return ! is_null($this->{$this->getDeletedAtColumn()});
    }

    public function detachAll(){
        foreach($this->categories as $category){
            $this->categories()->detach($category->id);
        }
    }
}
