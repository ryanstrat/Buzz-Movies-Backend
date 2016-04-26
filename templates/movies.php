<script type="text/javascript" src="/js/movies.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>Search Results for <span class="text-primary"><?php echo $q; ?></span></h1>
            <hr>
            
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody id="movieResults" >
                <!-- Movie Data Goes here -->
            </tbody>
        </table>
    </div>
</div>