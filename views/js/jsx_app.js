<script type="text/jsx">
React.render(
<h1>Hello, world!</h1>,
document.getElementById('example')
);

var data = [
  {author: "Leo Wang", age: '24', text: "Hello"},
  {author: "Kettan Wu", age: '25', text: "World"}
];

var CommentBox = React.createClass({
  render: function() {
    return (
      <div className="mui-container">
        <div className="mui-panel">
          <div className="commentBox">
            <h1>Comments</h1>
            <CommentList data={this.props.data} />
          </div>
        </div>
      </div>
    );
  }
});
var CommentList = React.createClass({
  render: function() {
    var CommentNodes = this.props.data.map(function (comment) {
      return (
        <Comment author={comment.author} age={comment.age}>
          {comment.text}
        </Comment>
      );
    });
    return (
      <div className="commentList">
        {CommentNodes}
      </div>
    );
  }
});
var Comment = React.createClass({
  render: function() {
    return (
      <div className="comment">
        <h2>
          {this.props.author}
          &nbsp;
          <small>
            {this.props.age}
          </small>
        </h2>
        {this.props.children}
      </div>
    );
  }
});

React.render(
  <CommentBox data={data} />,
  document.getElementById('content')
);

</script>
