@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">用户评论详情</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <td>用户：{{$comment->mobile}}</td>
                    <td>评论产品：【{{$comment->pro_name}}】</td>
                </tr>
                <tr>
                    <td>评分：{{$comment->score}}</td>
                    <td>评论时间：{{$comment->created_at}}</td>
                </tr>
                <tr>
                    <td colspan="2">评论内容：{{$comment->comment}}</td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="javascript:history.go(-1);"><button type="button" class="btn btn-default">返回</button></a>

        </div>

    </div>

    <script>


    </script>





@endsection