<table border="1">
    <tr>
        <td>id</td>
        <td>用户</td>
        <td>邮箱</td>
        <td>注册时间</td>
        <td>最后登录时间</td>
    </tr>

    <tr>
        <td>{{$data['user_id']}}</td>
        <td>{{$data['user_name']}}</td>
        <td>{{$data['user_email']}}</td>
        <td>{{date('Y-m-d H:i:s',$data['reg_time'])}}</td>
        <td></td>
    </tr>

</table>