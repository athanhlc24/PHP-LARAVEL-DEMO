<div class="form-group">
    <label>{{$label}}</label>
    <input type="{{$type}}" name="{{$key}}" value="{{ isset($value)?$value:old($key)}}"
           class="@error($key)is-invalid @enderror form-control"
           @if($required) required @endif>
    @error($key)
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>
