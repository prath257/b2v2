

@if($type=='single')

    <div class="col-lg-12" id="singlePost">

    <?php $numbers = str_random(3);?>

             <div id="readDiary{{$numbers}}" style="display: none">
             </div>

            <textarea class="input-block-level summernote" id="summernote{{$numbers}}" name="summernote" rows="18" onfocus="checkCharacters()">

            </textarea>

            <br><br>
            <div class="saveNedit{{$numbers}}">
                <button id="btnSave{{$numbers}}" class="btn btn-success" onclick="save('{{$numbers}}','save')"  >Save</button>

                <button id="btnEdit{{$numbers}}" class="btn btn-success" onclick="showEdit('{{$numbers}}','edit')" style="display: none">Edit</button>
            </div>


            <input type="hidden" id="editOrSave{{$numbers}}" value="">


         </div>

@else

  @foreach($diaries as $diary)

    <div class="col-lg-12" id="singlePost">


             <div id="readDiary{{$diary->id}}">
               {{$diary->text}}

             </div>
             <div class="right-align">
                                     <?php
                                         $postDate = $diary->created_at;
                                         $postDate = new DateTime($postDate);
                                         $postHour = $postDate->format('H');
                                         if ($postHour > 12)
                                         {
                                             $postHour = $postHour-12;
                                             $ext = 'PM';
                                         }
                                         else
                                             $ext = 'AM';
                                         $postDt = $postDate->format('d-m-Y');
                                         $postMin = $postDate->format('i');
                                      ?>
                                     {{$postDt}} {{$postHour}}:{{$postMin}} {{$ext}}
             </div>
            @if (Auth::user()->id == $diary->userid)
            <div id="summernoteTextarea{{$diary->id}}">
            <textarea style="display:none" class="input-block-level" id="summernote{{$diary->id}}" name="summernote" rows="18" onfocus="checkCharacters()">

            </textarea>
            <div class="right-align">
            <br>
            <div class="saveNedit{{$diary->id}}">
                            <a id="btnSave{{$diary->id}}" class="hand-over-me btn btn-success" onclick="save({{$diary->id}},'edit')" style="display: none">Save</a>

                            <a id="btnEdit{{$diary->id}}" class="hand-over-me" onclick="showEdit({{$diary->id}})">Edit</a>

                            <a id="btnDelt{{$diary->id}}" class="hand-over-me" onclick="showDelt({{$diary->id}})">Delete</a>
            </div>
            </div>
            </div>
            @endif


            <input type="hidden" id="editOrSave{{$diary->id}}" value="">

            <hr>

         </div>

    @endforeach

@endif
