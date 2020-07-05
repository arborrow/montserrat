@extends('template')

@section('content')
    <div class="row bg-cover">
        <div class="col-md-12">
            <h1>Balance Transactions</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div id="toolbar" style="padding: 20px;">
                    <div class="form-inline" role="form">
                        <div class="form-group">
                            <span>Limit: </span>
                            <input name="limit" class="form-control w70" type="number" value="10" min="1" max="100">
                        </div>
                        <div class="form-group">
                            <input name="search" class="form-control" type="text" placeholder="Search" hidden>
                            <input id="objectId" class="form-control" type="text" hidden>
                            <input id="paginationDirection" class="form-control" type="text" hidden>
                        </div>
                        <button id="ok" type="submit" class="btn btn-default">Ok</button>
                        <button id="previous" type="submit" class="btn btn-default">Previous</button>
                        <button id="next" type="submit" class="btn btn-default">Next</button>
                    </div>
                </div>

                <table 
                    id="table"
                    data-toolbar="#toolbar"
                    data-data-field="data" 
                    data-toggle="table" 
                    data-thead-classes="thead-dark" 
                    data-query-params="queryParams" 
                    data-detail-view="true"
                    data-detail-formatter="detailFormatter"
                    data-response-handler="responseHandler" 
                    data-url="/transactions/all">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="description">Description</th>
                            <th data-field="amount" data-formatter="formatMoney">Amount</th>
                            <th data-field="status">Status</th>
                            <th data-field="reporting_category">Reporting Category</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var $table = $('#table');
    var $ok = $('#ok');
    var $previous = $('#previous');
    var $next = $('#next');
    $(function() {
        $ok.click(function () {
            $table.bootstrapTable('refresh');
        });
        $next.click(function () {
            var data = $table.bootstrapTable('getData');
            var objectId = document.getElementById('objectId');
            var paginationDirection = document.getElementById('paginationDirection');
            objectId.value = '';
            paginationDirection.value = '';
            if (data.length > 0) {
                objectId.value = data[data.length - 1].id;
                paginationDirection.value = 'next';
            }
            $table.bootstrapTable('refresh');
        });
        $previous.click(function () {
            var data = $table.bootstrapTable('getData');
            var objectId = document.getElementById('objectId');
            var paginationDirection = document.getElementById('paginationDirection');
            objectId.value = '';
            paginationDirection.value = '';
            if (data.length > 0) {
                objectId.value = data[0].id;
                paginationDirection.value = 'previous';
            }
            
            $table.bootstrapTable('refresh');
        });
    });
    function detailFormatter(index, row) {
        var html = [];
        $.each(row, function (key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        });
        return html.join('');
    }
    function formatMoney(amount) {
        var dollars = amount / 100;
        dollars = dollars.toLocaleString("en-US", {style:"currency", currency:"USD"});
        return dollars;
    }
    function queryParams(params) {
        $('#toolbar').find('input[name]').each(function () {
            params[$(this).attr('name')] = $(this).val()
        })
        var id = $('#objectId').val();
        var direction = $('#paginationDirection').val();
        if (id && direction) {
            params['id'] = id;
            params['direction'] = direction;
        }
        return params;
    }
    function responseHandler(res) {
        console.log(res);
        return res;
    }
</script>

@endsection