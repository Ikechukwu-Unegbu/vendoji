<!-- Modal -->
@foreach ($locations as $location)
<div class="modal fade" id="preview-{{ $location->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="preview-{{ $location->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="preview-{{ $location->id }}">{{ $location->user->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="text-center m-4">
                <img style="height: 5rem; width:5rem;" src="{{ $location->user->image() }}" class="img-fluid rounded-circle" id="output" alt="Profile">
                <h4 class="mt-3">{{ $location->user->name }}</h4>

                <table class="table  table-striped">
                    <tbody>
                        <tr>
                            <td style="width: 30%" class="text-start">IP</td>
                            <td class="text-start"><strong>{{ $location->ip }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">Country</td>
                            <td class="text-start"><strong>{{ $location->country_name }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">Country Code</td>
                            <td class="text-start"><strong>{{ $location->country_code }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">City</td>
                            <td class="text-start"><strong>{{ $location->city_name }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">Zip Code</td>
                            <td class="text-start"><strong>{{ $location->zip_code }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">Latitude</td>
                            <td class="text-start"><strong>{{ $location->latitude }}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 30%" class="text-start">Longitude</td>
                            <td class="text-start"><strong>{{ $location->longitude }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
