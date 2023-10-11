@extends('admin.layout.app')
@section('content')
<div class="container">
    @if (session()->has('success'))
        <div class="alert alert-success">
        @if(is_array(session()->get('success')))
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session()->get('success') }}
        @endif
            </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible">
         {!! session("error") !!}
    </div>
    @endif
    @if (count($errors) > 0)
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
        @endif
    @endif
    <br>
    <div class="card">
        <div class="card-header">
            <div class="row w-100"> 
                <div class="col-6">
                    <h4 class=""><span style="border-bottom: 4px solid #6773ff;">Country </span></h4>
                </div>
                <div class="col-6">                      
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcountry" style="float:right">Add Country</button>
                </div>           
            </div> </div>
            <div class=" justify-content-between align-items-center flex-wrap grid-margin">
              
                    <!-- Modal -->
                <div class="modal fade" id="addcountry" tabindex="-1" aria-labelledby="folderLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="folderLabel">Add Country</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <form action="{{route('admin.country.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                                <div class="form-group">
                                    <label id="folderLabel">Partner</label><br>
                                    <input type="checkbox" name="admitad" > <span>Admited</span>        
                                    <input type="checkbox" name="cuelink"  >  <span>Cuelink</span>       
                                    <input type="checkbox" name="impact" ><span>Impact</span>       
                                </div>                                            
                                <div class="form-group">
                                    @php($de_co=\App\Models\DefaultCountry::get())
                                <label id="folderLabel">Select Country</label>
                                <select class="form-control" name="country">
                                    @foreach($de_co as  $de_country)
                                    <option value="{{$de_country->id}}">{{$de_country->country_name}} </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group">
                                <label id="folderLabel">Currency</label>
                                 <select name="currency" class="form-control js-select2-custom">
                                    @foreach(\App\Models\Currency::orderBy('currency_code')->get() as $currency)
                                        <option
                                            value="{{$currency['currency_code']}}">
                                            {{$currency['currency_code']}} ( {{$currency['currency_symbol']}} )
                                        </option>
                                    @endforeach
                                </select>
                                </div>                    
                                                                 
                                <div class="form-group">
                                <label id="folderLabel">Slug(Not Changeable Later)</label>
                                <input type="text"  name="slug" class="form-control no-space" placeholder="in">        
                                </div>                    
                                                  
                                    
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="card-content collapse show">
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('#') }}</th>
                                    <th>Country Name</th>
                                    <th>Country Code</th>
                                    <th>Slug</th>
                                    <th>Status</button></th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody  class="table-tbody" id="table-div"> 
                                 <?php $i = 1; ?>
                             @foreach($country as $key=>$partner)
                                <tr>
                                    <td id="row">{{$i}}</td>
                                   
                                    <td class="sort-id">{{$partner->country_name}}</td>
                                    <td class="sort-id">{{$partner->country_code}}</td>
                                    <td class="sort-name"> {{$partner->slug}}</td>
                                     <td class="sort-role"> <center> <label class="form-check form-check-single form-switch" for="stocksCheckboxactive{{$partner->id}}">
                                          <input type="checkbox" class="form-check-input" onclick="myFunction2{{$partner->id}}()" id="stocksCheckboxactive{{$partner->id}}" {{$partner->status?'checked':''}}>
                                          </label>
                                        </center>
                                        <script>
                                    function myFunction2{{$partner->id}}() {
                                      if (window.confirm('Do you want to change the active status?'))
                                    {
                                        window.location.href = "{{route('admin.country.active_status',[$partner->id,$partner->status?0:1])}}"
                                    }
                                    }
                                    </script>                                    
                                    </td>
                                    <td class="sort-name"> {{$partner->currency_symbol}}</td>
                                    <td class="sort-type">
                                    <div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item"
                                                    href="{{route('admin.country.edit',[$partner['id']])}}" title="edit partner">Edit
                                                </a>
                                                <a  href="{{route('admin.country.delete',[$partner['id']])}}" class="dropdown-item" href="javascript:"
                                                    onclick="return confirm('Are you sure?');" title="delete partner">Delete
                                                </a>
                                      </div>
                                    </div>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                        
                            @endforeach                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
  
@endsection
@push('script')
<script type="text/javascript">
$(document).ready(function() {
  

// do not allow users to enter spaces:
  $(".no-space").on({
    keydown: function(event) {
      if (event.which === 32)
        return false;
    },
    // if a space copied and pasted in the input field, replace it (remove it):
    change: function() {
      this.value = this.value.replace(/\s/g, "");
    }
  });

});
</script>
@endpush