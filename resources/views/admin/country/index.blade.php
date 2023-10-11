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
            </div>
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
                                <label id="folderLabel">Currency Code</label>
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