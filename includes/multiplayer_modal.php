<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create riddle</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="categoryModal">Category (3-20 characters)</label>
                    <input type="text" id="categoryModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="descriptionModal">Description (3-60 characters)</label>
                    <input type="text" id="descriptionModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddleModal">Riddle (3-60 characters)</label>
                    <input type="text" id="riddleModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddle_levelModal">Level (1-100)</label>
                    <input type="number" id="riddle_levelModal" class="form-control">
                </div>
                <input type="hidden" id="riddle_idModal" class="form-control">
            </div>
            <div class="modal-footer">
                <a href="javascript:;" id="save" class="btn btn-primary pull-right">Create</a>
            </div>
        </div>

    </div>
</div>