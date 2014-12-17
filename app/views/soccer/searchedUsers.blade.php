@foreach($users as $player)
           @if($player->pset==true)
           <div class="col-xs-12 col-sm-8 col-md-7 searchResult noPad" onclick="addUser('{{$player->username}}')">
              <div class="col-xs-2 col-md-3 col-sm-3 noPad">
                  <img src="{{$player->profile->profilePic}}" width="45px" height="45px">
              </div>
              <div class="col-xs-10 col-md-6 col-sm-9">
                   <div class="col-xs-12 col-sm-12 col-md-12">
                      <b>{{$player->first_name}}&nbsp;{{$player->last_name}}</b>
                   </div>
                   <div class="col-xs-12 col-sm-12 col-md-12">
                              <i style="font-size: 10px">{{$player->username}}</i>
                   </div>
              </div>
           </div>
           @endif
           @endforeach