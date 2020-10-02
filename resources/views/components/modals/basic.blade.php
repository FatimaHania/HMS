<!-- Basic Modal -->
<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="min-height:300px;">
        <div id="modalLoader_div" style="min-height:200px; display:none;">
          <div class="d-flex justify-content-center">
            <div class="spinner-grow m-5" style="width: 3rem; height: 3rem; margin-top:100px !important;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
        {{ $slot }}
      </div>
      <div class="modal-footer">
        {{ $footer }}
      </div>
    </div>
  </div>
</div>