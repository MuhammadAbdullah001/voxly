<?php
//$team = \App\Team::where('leader_id',$user->id)->first();
//if(isset($team) && $team != null){
//    $name = $team->name;
//}elseif(isset($user->team_id) && $user->team_id >0){
//    $team_name = \App\Team::where('id',$user->team_id)->first();
//    $name = $team_name->name;
//}else{
//    $name = $user->name;
//}
//$team = Team::where('leader_id',$user->id)->first();
?>


<p><strong>Dear {{$user->name}},</strong></p>
<p> your two factor verification code is {{$code}}</p>
<br><br>


<table width="100%">
    <tr>
        <td width="50%">
            <b>Voxly Tuition</b> <br/>
            118 - 120 Streatham high Road,<br>
            London, SW16 1BW  <br/>
            Admissions@voxlytuition.co.uk <br/>
            www.voxlytuition.co.uk/ <br/>
        </td>
        <td width="16%"></td>
        <td width="34%">
            {{--<img width="195" height="51" src="{{asset('images/logo_white.png')}}">--}}

        </td>
    </tr>
</table>







<p style="color:dimgrey"><i>This is a system generated email. Please do not reply.</i></p><br><br>
<img src="{{asset('images/logo_white.png')}}" width="195" height="51">
