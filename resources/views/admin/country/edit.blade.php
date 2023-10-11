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
            <div class="col-6 card-title">
                <p style="float: left">Edit Country </p> 
            </div>
            <div class="col-6">                
                <a class="btn btn-primary" href="{{ route('admin.country.index')}}" style="float:right;">Back</a>
            </div>
        </div>
        <div class="card-body">
            <form class="form-group" action="{{route('admin.country.update',$country->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                              <div class="form-group">
                                    <label id="folderLabel">Partner</label><br>
                                    <input type="checkbox" name="admitad" @if($admitad->status==1) checked @endif> <span>Admited</span>        
                                    <input type="checkbox" name="cuelink"  @if($cuelink->status==1) checked @endif>  <span>Cuelink</span>       
                                    <input type="checkbox" name="impact" @if($impact->status==1) checked @endif><span>Impact</span>       
                                </div>                                             
                                <div class="form-group">
                                    @php($de_co=\App\Models\DefaultCountry::get())
                                <label id="folderLabel">Select Country</label>
                                <select class="form-control" name="country">
                                    @foreach($de_co as  $de_country)
                                    <option value="{{$de_country->id}}" @if($country->country_name == $de_country->country_name) selected @endif>{{$de_country->country_name}} </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group">
									
                                <label id="folderLabel">Currency</label>
                                <select name="currency" class="form-control js-select2-custom">
                                    @foreach(\App\Models\Currency::orderBy('currency_code')->get() as $currency)
                                        <option
                                            value="{{$currency['currency_code']}}" @if($currency['currency_code'] == $country['currency_code']) selected @endif>
                                            {{$currency['currency_code']}} ( {{$currency['currency_symbol']}} )
                                        </option>
                                    @endforeach
                                </select>
                                </div>                    
                                                                   
                                <div class="form-group">
                                <label id="folderLabel">Slug</label>
                                <input type="text" class="form-control no-space"  value="{{$country->slug}}" readonly disabled>        
                                </div>                    
           
       
        <div class="card-footer">
            <div>
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </div>
    </form>
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