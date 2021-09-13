<?php

namespace App\Http\Livewire\Admin\ProductsManagement\RecycleBin;

use App\Models\DeliveryServiceProvider;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class RecycleDeliveryServiceProvider extends Component
{
    use WithFileUploads,WithPagination,AuthorizesRequests;
    public $search,$status;

    protected $listeners=['restore'];


    public function confirmRestore($id){
        $this->emit('confirmRestore', $id);
    }

    public function restore($id){
        $delivery=DeliveryServiceProvider::onlyTrashed()->findOrFail($id);
        Gate::authorize('isAdmin');
        $delivery->restore();
        create_activity('Delivery Service Provider Restored',auth()->user()->id,auth()->user()->id);
        session()->flash('success',__('text.Restored Successfully'));

    }

    public function render()
    {
        $users=$this->search();
        return view('admin.productManagement.recycle_bin.recycle_delivery_service_provider',compact('users'))->extends('admin.layouts.appLogged')->section('content');
    }

    //search and return products paginated
    protected function search(){
        return DeliveryServiceProvider::onlyTrashed()->where(function($q){
            return $q
            ->when($this->status  == 2 || $this->status  == 1,function($q){
                $this->status  == 2 ? $q->where('activation',0):$q->where('activation',1);
            })
            ->where(function($q){
               $q->when($this->search,function ($q){
                 $q->where('name','like','%'.$this->search.'%')
                    ->orWhere('email','like','%'.$this->search.'%')
                    ->orWhere('phone','like','%'.$this->search.'%');
                });
            });

        })->latest()->paginate(10);
    }



}



