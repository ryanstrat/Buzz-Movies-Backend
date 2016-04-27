<link href="/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="/js/star-rating.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/movieDetail.js"></script>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <h1>Reviewing: <span class="text-primary" id="movieTitle"></span></h1>
            <form class="form-horizontal" id="reviewForm">
                <div class="form-group">
                    <label for="starRating" class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-8">
                        <input id="starRating" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="review" class="col-sm-2 control-label">Review</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Save Review</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>