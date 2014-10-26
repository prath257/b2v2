@if ($device=='Desktop' && $interest != 'Technology')
<div class="btn-group btn-group-justified">
@endif
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary active buttons" onclick="changeArticleType(this,'Article')" data-toggle="tooltip" data-placement="top" title="Use a plain text editor to write with formatting as desired by you.">
            Plain Article
        </button>
    </div>
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'List')" data-toggle="tooltip" data-placement="top" title="Use a template designed for making lists.">
            List
        </button>
    </div>

    @if ($interest == 'MoviesTelevision')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Film Review')" data-toggle="tooltip" data-placement="top" title="Use a template designed for writing film reviews.">
            Film Review
        </button>
    </div>
    @elseif ($interest == 'Music')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Music Review')"data-toggle="tooltip" data-placement="top" title="Use a template designed for writing music reviews.">
            Music Review
        </button>
    </div>
    @elseif ($interest == 'Technology')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Code Article')" data-toggle="tooltip" data-placement="top" title="Use a template designed for writing and describing computer code.">
            Code Article
        </button>
    </div>
    <div class="btn-group mobileButton">
            <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Website Review')" data-toggle="tooltip" data-placement="top" title="Use a template designed for reviewing websites.">
                Website Review
            </button>
        </div>
        <div class="btn-group mobileButton">
            <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Gadget Review')" data-toggle="tooltip" data-placement="top" title="Use a template designed for reviewing new gadgets.">
                Gadget Review
            </button>
        </div>
    @elseif ($interest == 'Literature')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Book Review')" data-toggle="tooltip" data-placement="top" title="Use a template designed for writing a review of the book that you just read.">
            Book Review
        </button>
    </div>

    @elseif ($interest == 'Cooking')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Recipe')" data-toggle="tooltip" data-placement="top" title="Use a template designed for sharing your delicious recipes.">
            Recipe
        </button>
    </div>
    @elseif ($interest == 'Travel')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Travel Guide')" data-toggle="tooltip" data-placement="top" title="Use a template to write a guide-book for a place that you've visited.">
            Travel Guide
        </button>
    </div>
    @elseif ($interest == 'Gaming')
    <div class="btn-group mobileButton">
        <button type="button" class="btn btn-primary buttons" onclick="changeArticleType(this,'Game Review')" data-toggle="tooltip" data-placement="top" title="Review the game that you recently played.">
            Game Review
        </button>
    </div>
    @endif
@if ($device=='Desktop' && $interest != 'Technology')
</div>
@endif
