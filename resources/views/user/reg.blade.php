<form action="{{url("user/regdo")}}" method="post">@csrf
    <table>
        <tr>
            <td>账号</td>
            <td><input type="text" name="user_name">
                <font color="red">{{$errors->first("user_name")}}</font>
            </td>
        </tr>
        <tr>
            <td>email</td>
            <td><input type="text" name="user_email">
                <font color="green">{{$errors->first("user_email")}}</font>
            </td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="password">
                <font color="yellow">{{$errors->first("password")}}</font>
            </td>
        </tr>
        <tr>
            <td>确认密码</td>
            <td><input type="password" name="user_password">
                <font color="orange">{{session("msg")}}</font>
            </td>
        </tr>
        <tr>
            <td><a href="{{url('user/login')}}">登录</a></td>
            <td><input type="submit" value="注册"></td>
        </tr>
    </table>
</form>