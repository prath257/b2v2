
<fieldset>
            <div class="col-lg-12">

                @if($ifcRem>0)

                <div class="col-lg-4 offset2" style="border:2px ; padding: 10px 30px; text-align: center;">
                    <p>You Have <h3>{{$ifcAval}} <small>ifc</small></h3></P>
                </div>

                <div class="col-lg-4 offset2" style="border:2px ; padding: 10px 30px; text-align: center;">
                    <p>You need<h3>{{$ifcReq}} <small>ifc</small></h3></p>
                </div>

                <div class="col-lg-4 offset2" style="border:2px ; padding: 10px 30px; text-align: center;">
                    <p>You'll have<h3>{{$ifcRem}} <small>ifc</small></h3></p>
                </div>



                @else

                <div class="col-lg-6 offset3" style="border:2px ; padding: 10px 30px; text-align: center;">
                    <p>You Have <h3>{{$ifcAval}} <small>ifc</small></h3></P>
                </div>

                <div class="col-lg-6 offset3" style="border:2px ; padding: 10px 30px; text-align: center;">
                    <p>You need<h3>{{$ifcReq}} <small>ifc</small></h3></p>
                </div>

                @endif


            </div>
    <br>

    @if($content=='true')
   <div style="text-align: center;">

           @if($ifcRem>=0)
               @if (Str::contains($link,'sym140Nb971wzb4284'))
                   <a class="btn btn-primary" onclick="purchaseRes('{{$link}}')">Purchase Content</a>
               @else
                   <a href="http://localhost/b2v2/{{$link}}" class="btn btn-primary">Purchase Content</a>
               @endif
           @else
           <a href="{{route('ifcDeficit')}}" class="btn btn-success">Earn IFCs</a>
           @endif
           <a  class="btn btn-warning" data-dismiss="modal">Cancel</a>

   </div>
@endif

    </fieldset>