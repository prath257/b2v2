@if ($type == 'Article')
    <textarea class="input-block-level" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
    </textarea>
@elseif ($type == 'List')
<div id="LIST{{$count}}">
    <label class="col-lg-2 control-label">Heading</label>
    <div class="form-group col-lg-10">
        <input id="ListHeader{{$count}}" type="text" class="form-control col-lg-12">
    </div>

    <label class="col-lg-2 control-label">Description</label>
    <div class="form-group col-lg-10">
        <textarea class="input-block-level col-lg-12" id="summ{{$count}}" name="summernote" rows="18" onfocus="checkCharacters()">
        </textarea>
    </div>
</div>
@elseif ($type == 'Travel Guide')
<div class="col-lg-4">
    <label class="col-lg-12">Destination</label>
    <div class="form-group col-lg-12">
        <input id="destination" type="text" name="destination" class="form-control col-lg-12" placeholder="The main travel destination place">
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Places to Visit</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="places" class="form-control" name="places" rows="3" placeholder="A short list of amazing places to visit."></textarea>
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Transportation</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="transportation" class="form-control" name="transportation" rows="3" placeholder="How do people travel at this location"></textarea>
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Accomodation</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="accomodation" class="form-control" name="accomodation" rows="3" placeholder="Write about accomodation facilities, fare etc"></textarea>
        </div>
    </div>
</div>
<div class="col-lg-8">
    <label class="col-lg-12">My Experience</label>
        <div class="form-group col-lg-12">
            <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>

    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Travel Advice </label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="advice" class="form-control" name="advice" rows="3" placeholder="Write about travel care, difficulties, what not to miss out on etc"></textarea>
        </div>
    </div>
</div>
@elseif ($type == 'Film Review')
    <div class="col-lg-8 col-lg-offset-2" style="text-align: center">
        <div id="film-review-initial-select-list" class="col-lg-12 film-review-blocks">
            <h4>Select all the elements that you'd like to include in your film review.</h4>

            <div class="form-group">
            <div id="filmreviewindex" style="text-align: left">
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="year"> Year<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="genre"> Genre<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="director"> Director<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="cast"> Cast<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="plot"> Plot Synopsis<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="expectations"> Prior Expectations<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="story"> Story / Screenplay<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="my-review"> My Review<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="acting"> Acting<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="technical"> Technical Aspects<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="rating"> My Rating<br>
                <input type="checkbox" class="filmreviewindex col-lg-6" name="filmreviewindex[]" value="afterfeeling"> After Feeling<br>
            </div>
            </div>
            <br>
            <button id="filmreviewindexformsubmit" type="button" class="btn btn-success" onclick="getStartedFilmReview()">Get Started</button>


        </div>

        <div id="film-review-year" class="col-lg-12 film-review-blocks" style="display: none">
        <label class="col-lg-12">Release Year</label>
        <div class="form-group col-lg-12">
            <input id="year" type="text" name="year" class="form-control col-lg-12" placeholder="When was this film released?">
        </div>
        <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-genre" class="col-lg-12 film-review-blocks" style="display: none">
<label class="col-lg-12">Genre</label>
        <div class="form-group col-lg-12">
            <input id="genre" type="text" name="genre" class="form-control col-lg-12" placeholder="Genre of the film">
        </div>
        <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-director" class="col-lg-12 film-review-blocks" style="display: none">
<label class="col-lg-12">Directed By:</label>
        <div class="form-group col-lg-12">
            <input id="director" type="text" name="director" class="form-control col-lg-12" placeholder="Name of the Director(s)">
        </div>
        <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-cast" class="col-lg-12 film-review-blocks" style="display: none">
<label class="col-lg-12" style="padding-left: 15px">Cast</label>
            <div class="form-group col-lg-12" style="padding: 0px">
                <textarea id="cast" class="form-control" name="cast" rows="3" placeholder="List the main performers"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-plot" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12" style="padding-left: 15px">Plot Synopsis</label>
            <div class="form-group col-lg-12" style="padding: 0px">
                <textarea id="plot" class="form-control" name="plot" rows="3" placeholder="Write in short what this movie is all about"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-expectations" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12" style="padding-left: 15px">Prior Expectations</label>
            <div class="form-group col-lg-12" style="padding: 0px">
                <textarea id="expectations" class="form-control" name="expectations" rows="3" placeholder="what were you expecting before watching"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-story" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12" style="padding-left: 15px">Story/Screenplay</label>
            <div class="form-group col-lg-12" style="padding: 0px">
                <textarea id="story" class="form-control" name="story" rows="3" placeholder="What about the story and screenplay, how was it?"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-my-review" class="col-lg-12 film-review-blocks" style="display: none">
<label class="col-lg-12">My Review</label>
        <div class="form-group col-lg-12" style="text-align: left">
            <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>
        <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-acting" class="col-lg-12 film-review-blocks" style="display: none">
<label class="col-lg-12">Acting </label>
            <div class="form-group col-lg-12">
                <textarea id="acting" class="form-control" name="acting" rows="3" placeholder="How did the lead cast do?"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-technical" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12">Technical Aspects </label>
            <div class="form-group col-lg-12" style="padding-left: 15px; padding-right: 0px">
                <textarea id="technical" class="form-control" name="technical" rows="3" placeholder="Camerawork, editing, colors?"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-rating" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12">My Rating </label>
            <div class="form-group col-lg-12">
                <input id="rating" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

        <div id="film-review-afterfeeling" class="col-lg-12 film-review-blocks" style="display: none">
<label class=" col-lg-12" style="padding-left: 50px">After Feeling </label>
            <div class="col-lg-12" style="padding-left: 50px">
                <textarea id="afterfeeling" class="form-control" name="after" rows="3" placeholder="At the end of it, how did you feel?"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="nextElementFilmReview()">Next</button>
        </div>

                <div id="film-review-done" class="col-lg-12 film-review-blocks" style="display: none">
                    <h4>That bring us to the end of the review. Click on 'Preview and Submit' below to do the final thing.</h4>
                </div>
    </div>

@elseif ($type == 'Music Review')
    @if ($count == 1)
<div class="col-lg-4">
        <label class="col-lg-12">Year</label>
        <div class="form-group col-lg-6">
            <input id="year" type="text" name="year" class="form-control col-lg-12">
        </div>
        <label class="col-lg-12">Genre</label>
        <div class="form-group col-lg-6">
            <input id="genre" type="text" name="genre" class="form-control col-lg-12">
        </div>
        <div class="form-group col-lg-12">
            <label class=" col-lg-12">Music Producer(s)</label>
            <div class="col-lg-12" style="padding: 0px">
                <input id="musicProducer" type="text" name="musicProducer" class="form-control col-lg-12">
            </div>
        </div>
        <label class="col-lg-12">Lyricist(s)</label>
        <div class="form-group col-lg-12">
            <input id="lyricist" type="text" name="lyricist" class="form-control col-lg-12">
        </div>
        <div class="form-group col-lg-12">
            <label class=" col-lg-12">Prior Expectations</label>
            <div class="col-lg-12" style="padding: 0px">
                <textarea id="priorExpectations" class="form-control" name="priorExpectations" rows="3" placeholder="All of your thoughts before listening to the tracklist."></textarea>
            </div>
        </div>
</div>
<div class="col-lg-8" id="trackList">
    @endif
<div id="TRACK{{$count}}">
    <label class="col-lg-12">Track Name</label>
    <div class="form-group col-lg-10">
        <input id="trackName{{$count}}" type="text" name="trackName{{$count}}" class="form-control col-lg-12">
    </div>
    <label class="col-lg-12">Track Review</label>
    <div class="form-group col-lg-10">
        <textarea class="input-block-level col-lg-12" id="summ{{$count}}" name="summernote" rows="18" onfocus="checkCharacters()">
        </textarea>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-3 control-label">Track Rating </label>
        <div class="col-lg-5">
            <input id="rating{{$count}}" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
        </div>
    </div>
</div>
    @if ($count==1)
</div>
@endif
@elseif ($type == 'Book Review')
<div class="col-lg-4">
    <label class="col-lg-12">Year</label>
    <div class="form-group col-lg-12">
        <input id="year" type="text" name="year" class="form-control col-lg-12">
    </div>
    <label class="col-lg-12">Genre</label>
    <div class="form-group col-lg-12">
        <input id="genre" type="text" name="genre" class="form-control col-lg-12">
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Author(s)</label>
        <div class="col-lg-12" style="padding: 0px">
            <input id="author" type="text" name="author" class="form-control col-lg-12">
        </div>
    </div>
    <label class="col-lg-12">Publisher</label>
    <div class="form-group col-lg-12">
        <input id="publisher" type="text" name="publisher" class="form-control col-lg-12">
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Synopsis</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="synopsis" class="form-control" name="synopsis" rows="3"></textarea>
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Film Adaptations?</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="filmAdaptation" class="form-control" name="filmAdaptation" rows="3"></textarea>
        </div>
    </div>
</div>
<div class="col-lg-8">
    <label class="col-lg-12">Review</label>
    <div class="form-group col-lg-12">
        <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
        </textarea>
    </div>
    <div class="form-group col-lg-12p">
        <label class=" col-lg-12">Rating </label>
        <div class="col-lg-5">
            <input id="rating" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
        </div>
    </div>
</div>

@elseif ($type == 'Recipe')

<div class="form-group">
    <label class="col-lg-2 control-label">Preparation Time</label>
    <div class="col-lg-2">
        <div class="input-group col-lg-12">
            <input type="text" id="preparationTime" class="form-control">
            <span class="input-group-addon">mins.</span>
        </div>
        <br>
    </div>

</div>

<div class="form-group">
    <label class="col-lg-2 control-label">Difficulty</label>
    <div class="col-lg-2">
        <input type="text" id="difficulty" class="form-control">
    </div>
    <br>
</div>
<br>

<div class="form-group">
    <label class="col-lg-2 control-label">Cuisine</label>
    <div class="col-lg-2">
        <input type="text" id="cuisine" class="form-control">
    </div>
    <br>
</div>
<br>

<div class="form-group">
    <label class="col-lg-2 control-label">Ingredients</label>
    <div class="col-lg-7">
        <textarea id="ingredients" rows="5" class="form-control"></textarea>
    </div>
    <br>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Steps</label>
    <div class="col-lg-10">
        <textarea class="input-block-level" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
        </textarea>
    </div>
</div>


<div class="form-group">
    <label class="col-lg-2 control-label">Tips</label>
    <div class="col-lg-7">
        <textarea id="tips" rows="3" class="form-control"></textarea>
    </div>
</div>
@elseif ($type == 'Code Article')
    @if ($count == 1)
        <label class="col-lg-2 control-label">Introduction</label>
        <div class="form-group col-lg-10">
            <textarea id="introduction" rows="5" style="width: 100%" class="form-control"></textarea>
            <br>
        </div>
    @endif
    <div id="CABLOCK{{$count}}">
        <label class="col-lg-2 control-label">Code</label>
        <div class="form-group col-lg-10">
            <textarea class="input-block-level col-lg-12" id="summ{{$count}}" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>

        <label class="col-lg-2 control-label">Explanation</label>
        <div class="form-group col-lg-10">
            <textarea class="input-block-level col-lg-12" id="summm{{$count}}" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>
    </div>
@elseif ($type == 'Game Review')
<div class="col-lg-4">
    <div class="form-group">
        <div class="col-lg-12">
            <input type="text" id="title" class="form-control" placeholder="Title of the game." autofocus="">
        </div>
        <br>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-5" style="padding: 0px">
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" id="year" class="form-control" placeholder="Release year.">
            </div>
            <br>
        </div>
    </div>
    <div class="col-lg-2">&nbsp;</div>
    <div class="col-lg-5" style="padding: 0px">
        <div class="form-group">
            <div class="col-lg-12">
                <input type="text" id="genre" class="form-control" placeholder="Genre.">
            </div>
            <br>
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <div class="col-lg-12">
            <input type="text" id="developer" class="form-control" placeholder="Developer(s)">
        </div>
        <br>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <div class="col-lg-12">
            <input type="text" id="publisher" class="form-control" placeholder="Publisher(s)">
        </div>
        <br>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <div class="col-lg-12">
            <input type="text" id="trailer" class="form-control" placeholder="YouTube link to the trailer.">
        </div>
        <br>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group">
        <div class="col-lg-12">
            <textarea id="priorExpectations" class="form-control" rows="5" placeholder="Prior Expectations." style="resize: none"></textarea>
        </div>
        <br>
    </div>
</div>
<div class="col-lg-8">
    <label class="col-lg-2 control-label">The Review</label>
    <div class="form-group col-lg-10">
        <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
        </textarea>
    </div>

    <div class="form-group col-lg-12p">
        <label class=" col-lg-2 control-label">Score </label>
        <div class="col-lg-10">
            <input id="rating" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
        </div>
    </div>
</div>





@elseif ($type == 'Gadget Review')
<div class="col-lg-4">
    <label class="col-lg-12">Product Name</label>
    <div class="form-group col-lg-6">
        <input id="pname" type="text" name="pname" class="form-control col-lg-12">
    </div>
    <label class="col-lg-12">Release Date</label>
    <div class="form-group col-lg-6">
        <input id="date" type="text" name="date" class="form-control col-lg-12">
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Company</label>
        <div class="col-lg-12" style="padding: 0px">
            <input id="comp" type="text" name="comp" class="form-control col-lg-12">
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Prior Expectations</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="expectations" class="form-control" name="expectations" rows="3" placeholder="All of your thoughts before using this gadget."></textarea>
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Specifications</label>
        <div class="col-lg-12" style="padding: 0px">
            <textarea id="specifications" class="form-control" name="specifications" rows="3" placeholder="Every specification of this product."></textarea>
        </div>
    </div>
</div>
<div class="col-lg-8">

    <div>

        <label class="col-lg-12">My Review</label>
        <div class="form-group col-lg-10">
            <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>
        <div class="form-group col-lg-12">
            <label class=" col-lg-1 control-label">My Rating </label>
            <div class="col-lg-5">
                <input id="rating" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
            </div>
        </div>
    </div>

</div>
@elseif ($type == 'Website Review')
<div class="col-lg-4">
    <div class="col-lg-12">&nbsp;</div>
    <label class="col-lg-12">Website Name</label>
    <div class="form-group col-lg-10">
        <input id="wname" type="text" placeholder="Common name of the website."  name="pname" class="form-control col-lg-12">
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <label class="col-lg-12">Founder(s)/Developer(s)</label>
    <div class="form-group col-lg-10">
        <input id="founder" type="text" placeholder="Any known founder or developer." name="founder" class="form-control col-lg-12">
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Genre</label>
        <div class="col-lg-12" style="padding: 0px">
            <input id="genre" type="text" placeholder="E-commerce, banking, social networking, etc." name="genre" class="form-control col-lg-12">
        </div>
    </div>
    <div class="col-lg-12">&nbsp;</div>
    <div class="form-group col-lg-12">
        <label class=" col-lg-12">Link to website</label>
        <div class="col-lg-12" style="padding: 0px">
            <input id="link" type="text" placeholder="URL of the website" name="link" class="form-control col-lg-12">
        </div>
    </div>
    <div class="form-group col-lg-12">
         <label class=" col-lg-12">My Rating </label>
         <input id="rating" value="2" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm">
    </div>
</div>

<div class="col-lg-8">

    <div>

        <label class="col-lg-12">My Review</label>
        <div class="form-group col-lg-10">
            <textarea class="input-block-level col-lg-12" id="summernote" name="summernote" rows="18" onfocus="checkCharacters()">
            </textarea>
        </div>

    </div>

</div>

@endif