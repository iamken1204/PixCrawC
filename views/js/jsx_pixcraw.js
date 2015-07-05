$('#loader').hide();
$table = $('#url-table');

var _core = {
    rank: 0,
    target: 'blogger',
    category: 0,
    top: 0,
    fetchArticleUrl: function() {
        this.top = 100;
        $table.append('<div id="rank-a-' + this.rank + '"></div>');
        var data = {
            rank: this.rank,
            target: this.target
        };
        $.ajax({
            url: '/pixcraw.php?rt=getPixUrl',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(res, status, xhr) {
                console.log("fetching " + data.target + " rank: " + data.rank + " ...success!");
                var Url = React.createClass({
                    render: function() {
                        return (
                            <div className="url">
                                <p>URL goto={this.props.data.url}</p>
                            </div>
                        );
                    }
                });
                React.render(
                    <Url data={res.url} />,
                    document.getElementById('rank-a-' + res.domID)
                );
                _core.top--;
                if (_core.top > 0)
                    $('#loader').show();
                else
                    $('#loader').hide();
            },
            error: function() {
                console.log("fetching" + data.target + "rank: " + data.rank + " ...error!");
                _core.top--;
                if (_core.top > 0)
                    $('#loader').show();
                else
                    $('#loader').hide();
            }
        });
    },
    fetchBloggerUrl: function() {
        this.top = 1500;
        $table.append('<div id="rank-b-' + this.category + '-' + this.rank + '"></div>');
        var data = {
            rank: this.rank,
            target: this.target,
            category: this.category
        };
        $.ajax({
            url: '/pixcraw.php?rt=getPixUrl',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(res, status, xhr) {
                console.log("fetching " + data.target + " category: " + data.category + " rank: " + data.rank + " ...success!");
                var Url = React.createClass({
                    render: function() {
                        return (
                            <div className="url">
                                <p>URL goto={this.props.data.url}</p>
                            </div>
                        );
                    }
                });
                React.render(
                    <Url data={res.url} />,
                    document.getElementById('rank-b-' + res.category + '-' + res.domID)
                );
                _core.top--;
                if (_core.top > 0)
                    $('#loader').show();
                else
                    $('#loader').hide();
            },
            error: function() {
                console.log("fetching" + data.target + "rank: " + data.rank + " ...error!");
                _core.top--;
                if (_core.top > 0)
                    $('#loader').show();
                else
                    $('#loader').hide();
            }
        });
    }
};

$('#js-tArticle').click(function() {
    for (rank = 1; rank <= 100; rank++) {
        _core.rank = rank;
        _core.target = 'article';
        _core.fetchArticleUrl();
    }
});

$('#js-tBlogger').click(function() {
    for (category = 1; category <= 15; category++) {
        _core.category = category;
        _core.target = 'blogger';
        for (rank = 1; rank <= 100; rank++) {
            _core.rank = rank;
            _core.fetchBloggerUrl();
        }
    }
});
