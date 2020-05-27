@csrf
<div class="form-group">
    <label for="first_name">First Name</label>
    <input name="first_name" type="string" class="form-control" value="{{old('first_name',$contact->first_name)}}">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input name="email" type="email" class="form-control" value="{{old('email',$contact->email)}}">
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    <input name="phone" type="string" class="form-control" value="{{old('phone',$contact->phone)}}">
</div>
<button type="submit" class="btn btn-primary">Submit</button>