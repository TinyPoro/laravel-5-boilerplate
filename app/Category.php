<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function news(){
        return $this->belongsToMany('App\News');
    }

    public function getParentNameAttribute(){
        $parent = self::find($this->parent_id);

        if($parent) return $parent->name;
        return "";
    }

    public function getNewsCountAttribute(){
        return count($this->news);
    }
    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="'.route('admin.auth.category.show', $this).'" class="btn btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.view').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="'.route('admin.auth.category.edit', $this).'" class="btn btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.edit').'"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="'.route('admin.auth.category.destroy', $this).'" data-method="delete" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.general.crud.delete').'"></i></a>';
    }

    public function getRestoreButtonAttribute()
    {
        return '<a href="'.route('admin.auth.category.restore', $this).'" name="confirm_item" class="btn btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.news_management.category.restore_user').'"></i></a>';
    }

    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="'.route('admin.auth.category.delete-permanently', $this).'" name="confirm_item" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('buttons.backend.news_management.category.delete_permanently').'"></i></a>';
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

    public function canHaveParent($id){
        $cur_id = $id;

        do{
            $cate = self::find($cur_id);
            $parent_id = $cate->parent_id;

            if($parent_id == $this->id) return false;

            $cur_id = $parent_id;
        }while($cur_id != null);

        return true;
    }
}
