<table class="table">
<thead>
    <h3 class="text-center text-dark">Locking Durations</h3>
</thead>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Duration</th>
      <th scope="col">Created On</th>
      <th scope="col">Disable</th>
    </tr>
  </thead>
  <tbody>
    @foreach($locks as $lock)
    <tr>
      <th scope="row">{{$lock->id}}</th>
      <td>{{$lock->duration}}</td>
      <td>{{$lock->created_at}}</td>
      <td>@if($lock->state ==1) <button style="width: 8rem;" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deactivate-{{$lock->id}}">Deactivate</button> @else <button style="width: 8rem;" data-bs-toggle="modal" data-bs-target="#activate-{{$lock->id}}" class="btn btn-sm btn-success">Activate</button>@endif</td>
    </tr>
    @include('admin.lock.include._activate_deactivate_modal')
    @endforeach
    
  </tbody>
</table>


