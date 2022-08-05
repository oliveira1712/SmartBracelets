<table class="table">
    <thead>
    <tr>
        <th scope="col">UserID</th>
        <th scope="col">Email</th>
        <th scope="col">Status</th>
        <th scope="col">Browser</th>
        <th scope="col">Plataforma</th>
        <th scope="col">Ip</th>
        <th scope="col">Ultimo Login</th>
        
    </tr>
    </thead>
    <tbody>
        
        @foreach ($usersinfo as $userinfo)
            
            <tr>
                <td>{{ $userinfo->userid }}</td>
                <td>{{ $userinfo->email}}</td>
                @if ($userinfo->isOnline($userinfo->id))
                    <td>
                        <li class="text-success">
                            Online
                        </li>
                        
                    </td>
                @else 
                    <td>
                        <li class="text-muted">
                            Offline
                        </li>
                    </td>
                @endif
                
                
                <td>{{$userinfo->browser}}</td>
                <td>{{$userinfo->plataforma}}</td>
                <td>{{$userinfo->ip}}</td>
                <td>{{$userinfo->current_sign_in_at}}</td>
                
                
               
            </tr>
        @endforeach
    </tbody>
    
</table>
<div class="paginacao" style="float: right; margin-top: 2rem;">
    {{ $usersinfo->links() }}
</div>