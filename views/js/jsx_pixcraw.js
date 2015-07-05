$table = $('#url-table');

var _core = {
    rank: 0,
    target: 'blogger',
    fetchUrl: function() {
        $table.append('<div id="rank-' + this.rank + '"></div>');
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
                    document.getElementById(res.domID)
                );
            },
            error: function() {
                console.log('something went wrong!');
            }
        });
    }
};

$('#js-tArticle').click(function() {
    for (rank = 1; rank <= 100; rank++) {
        _core.rank = rank;
        _core.target = 'article';
        _core.fetchUrl();
    }
});

$('#js-tBlogger').click(function() {
    for (rank = 1; rank <= 100; rank++) {
        _core.rank = rank;
        _core.target = 'blogger';
        _core.fetchUrl();
    }
});
