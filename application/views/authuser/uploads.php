<link href="/assets/styles/authuser/uploads.css?1" rel="stylesheet"/>
<link href="/assets/styles/authuser/pagination.css?1" rel="stylesheet"/>
<div class="container">
    <form id="frm_upcsv" enctype='multipart/form-data' method="POST">
        <div class="row">
            <label>Upload CSV file to the system</label>
            <input type="file" id="csvfile" name="csv" accept=".csv"/>
            <button type="button" class="btn btn-primary btnupload">Upload</button>
        </div>

    </form>
    <div class="row">
        <button class="btn btn-primary btndeleteall">Delete All</button>
    </div>
    <div class="row table_area">
        <table id="list_leads" class="">
            <thead>
                <th>sent</th>
                <th>date_added</th>
                <th>date_sent</th>
                <th>address</th>
                <th>city</th>
                <th>state</th>
                <th>firstname</th>
                <th>lastname</th>
                <th>owner_address</th>
                <th>owner_city</th>
                <th>owner_state</th>
                <th>phone0</th>
                <th>phone1</th>
                <th>phone2</th>
                <th>phone3</th>
                <th>phone4</th>
                <th>phone5</th>
                <th>phone6</th>
                <th>phone7</th>
                <th>phone8</th>
                <th>phone9</th>
                <th>leadtype</th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
        <div class="pagination" id="pagination"> 
            <span class="prevpage">&lt;&lt;</span>
            <div class="pcontent">

            </div>
            <span class="nextpage">&gt;&gt;</span>
        </div>    
</div>
<script defer="defer" type="text/javascript" src="/assets/js/authuser/pagination.js?4"></script>
<script defer="defer" type="text/javascript" src="/assets/js/authuser/uploads.js?4"></script>