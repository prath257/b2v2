
$(document).ready(function()
{
    var predict={"user":5,"predictions":[]};

    var jsonObj = {
        "fathers": [{
            "age": 44,
            "name": "James Martin",
            "daughters": []
        }, {
            "age": 47,
            "name": "David Thompson",
            "daughters": [{
                "age": 20,
                "name": "Amy",
                "husband": {
                    "age": 26,
                    "name": "Edward"
                }
            }, {
                "age": 20,
                "name": "Dorothy",
                "husband": {
                    "age": 23,
                    "name": "Timothy"
                }
            }]
        }, {
            "age": 56,
            "name": "Thomas Young",
            "daughters": [{
                "age": 22,
                "name": "Sharon",
                "husband": {
                    "age": 23,
                    "name": "Jason"
                }
            }, {
                "age": 22,
                "name": "Carol",
                "husband": {
                    "age": 23,
                    "name": "William"
                }
            }, {
                "age": 20,
                "name": "Brenda",
                "husband": {
                    "age": 30,
                    "name": "Timothy"
                }
            }]
        }, {
            "age": 53,
            "name": "Jason Martinez",
            "daughters": [{
                "age": 19,
                "name": "Jessica",
                "husband": {
                    "age": 24,
                    "name": "Daniel"
                }
            }]
        }, {
            "age": 51,
            "name": "Thomas Gonzalez",
            "daughters": [{
                "age": 23,
                "name": "Brenda",
                "husband": {
                    "age": 30,
                    "name": "George"
                }
            }, {
                "age": 30,
                "name": "Dorothy",
                "husband": {
                    "age": 23,
                    "name": "Brian"
                }
            }]
        }, {
            "age": 41,
            "name": "James Lee",
            "daughters": [{
                "age": 20,
                "name": "Sarah",
                "husband": {
                    "age": 24,
                    "name": "Frank"
                }
            }, {
                "age": 21,
                "name": "Carol",
                "husband": {
                    "age": 28,
                    "name": "Larry"
                }
            }]
        }, {
            "age": 58,
            "name": "Kenneth Brown",
            "daughters": [{
                "age": 23,
                "name": "Ruth",
                "husband": {
                    "age": 24,
                    "name": "Brian"
                }
            }, {
                "age": 18,
                "name": "Lisa",
                "husband": {
                    "age": 24,
                    "name": "Scott"
                }
            }, {
                "age": 27,
                "name": "Sandra",
                "husband": {
                    "age": 31,
                    "name": "Charles"
                }
            }]
        }, {
            "age": 50,
            "name": "Thomas Lee",
            "daughters": [{
                "age": 27,
                "name": "Patricia",
                "husband": {
                    "age": 30,
                    "name": "Scott"
                }
            }, {
                "age": 21,
                "name": "Jennifer",
                "husband": {
                    "age": 23,
                    "name": "George"
                }
            }]
        }, {
            "age": 50,
            "name": "Robert Anderson",
            "daughters": [{
                "age": 24,
                "name": "Angela",
                "husband": {
                    "age": 23,
                    "name": "James"
                }
            }]
        }]
    };

    /*var family = jsonQ(jsonObj);
    var family = jsonQ(predict);
    //to find all the name
    var match = family.find('match');
    var index=match.index(2);


    //to print list of all name
    //document.write(index);
    $("#mydiv").html(predict.predictions[2].match);
    predict.predictions.splice(1,1);


    $("#mydiv").append(predict.predictions[1].match);
*/

    var family = jsonQ(predict);
    //to append a daughter in all daughter's key
    var newMatch = {
        "match": 5,
        "home": 2,
        "away":1,
        "homescorers":[{"pid":7},{"pid":9}],
        "awayscorers":[]

    }
    var newMatch2 = {
        "match": 7,
        "home": 1,
        "away":1,
        "homescorers":[11],
        "awayscorers":[7]

    }

    family.find('predictions').append(newMatch);
    family.find('predictions').append(newMatch2);


    //to add prediction
   // var family = jsonQ(predict);
    //var prediction = {"home":5,"away":2,"homescorer":[],"awayscorer":[]};
    //family.find('predictions').push(prediction);
    //document.write(predict.predictions[0].homescorers[0]);
    //document.write(predict.predictions[1].homescorers[0]);
    //to find all the name
    //--------------------------------------------useful-------------------
    /*family = jsonQ(predict);

    var match = family.find('match');
    var index=match.index(5);

    predict.predictions.splice(index,1);

    document.write("And the scorer is: "+predict.predictions[0].homescorers[0]);*/
//----------------------------------------------end---------------

    family = jsonQ(predict);
   // var match = family.find('match');
   // var index = match.index(5);
    // predict.predictions[index].home=100;
   // document.write("New home score is : "+predict.predictions[0].home+" and new away score is  "+predict.predictions[0].away);

   /* var match = family.find('match');
    var index = match.index(5);
    predict.predictions[index].homescorers.push(13);
    var hs;
    for(hs in predict.predictions[index].homescorers)
    {
        document.write(predict.predictions[index].homescorers[hs]);
    }*/

    var hs=0;

    var allmatch = family.find('match');
    var match = family.find('match',function(){
        return this == 5;
    });
    //alert("length of match is "+match.length);
    var nindex = allmatch.index(5);
    //alert('nindex is '+nindex);

   // var tempmatch = match.filter({"match":5});
    //alert("length of tempmatch is "+tempmatch.length);
    var ascorers = match.sibling('awayscorers');

    var scorer={"pid":9};

    ascorers.append(scorer);
    var scorer={"pid":8};
    ascorers.append(scorer);
    //alert("length of ascorers is "+ascorers.length);
    //var index = ascorers.index({"pid":11},true);
   // var index=ascorers.index(17);
    /*for(hs in ascorers)
    {
        if(ascorers[hs]==17)
        break;
    }*/

    //predict.predictions[nindex].awayscorers.splice(index,0);
    //hs = 0;
    /*for(hs in predict.predictions[nindex].awayscorers)
    {
        document.write(predict.predictions[nindex].awayscorers[hs].+"+");
    }*/
    document.write(predict.predictions[0].awayscorers[0].pid);
    document.write(predict.predictions[0].awayscorers[1].pid);


});


