<!DOCTYPE html>
<html>
<head>
    <title>Welcome | BBarters</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{asset('Images/icons/logo.JPG')}}">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrapValidator.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-responsive.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{asset('css/WPModal.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>

</head>
<body>

<div class="modal fade" id="twsignUpModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">

    <h4>Welcome Tweeples, lets get you in..</h4>
</div>

<div class="modal-body">

{{Form::open(array('route'=>'twsignup','id'=>'twsignupForm','class'=>'form-horizontal'))}}
<fieldset>
<input type="hidden" name="twid" id="twid" value="{{$twitterId}}">
<div class="form-group">
    <label class="col-lg-3 control-label">Username</label>
    <div class="col-lg-5">
        <input type="text" class="form-control" name="username" id="username" onblur="checkUname()" />

    </div>
    <label class="col-lg-4 control-label" id="uerror"></label>

</div>

<div class="form-group">
    <label class="col-lg-3 control-label">Email address</label>
    <div class="col-lg-5">
        <input type="text" class="form-control" name="email" id="email" autocomplete="off" onblur="checkEmail()" />
    </div>
    <label class="col-lg-4 control-label" id="merror"></label>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label">Gender</label>

    <div class="btn-group col-lg-5" data-toggle-name="gender" data-toggle="buttons-radio">
        <button type="button" value="male" id="male" class="btn btn-primary" data-toggle="button">Male</button>
        <button type="button" value="female" id="female" class="btn btn-primary" data-toggle="button">Female</button>
        <button type="button" value="other" id="other" class="btn btn-primary" data-toggle="button">Other</button>
    </div>


    <input type="hidden" id="gender" name="gender" value="0" />
</div>

<div class="form-group">
<label class="col-lg-3 control-label">Country</label>
<div class="col-lg-5">
<select class="form-control" name="country">
<option value="">-- Select a country --</option>
<option value="Afganistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America">United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select>
</div>
</div>


<div class="form-group">
    <div class="col-lg-5 col-lg-offset-3">
        <div class="checkbox">
            <input type="checkbox" name="acceptTerms" /> Accept the <a href="#" style="text-decoration: none" data-toggle="modal" data-target="#termsAndConditions">Terms and Policies</a>
        </div>
    </div>
</div>

</fieldset>

<div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>


{{Form::close()}}

</div>

</div>
</div>
</div>

<div class="modal fade" id="termsAndConditions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">TERMS AND CONDITIONS</h4>
            </div>
            <div class="modal-body">
                <fieldset>
                    <p>
                        These are standard rules about posting content on bbarters.com, through it on facebook,twitter and other social networking sites.
                        They are designed to ensure users feel safe, keen to take part again and keep to its focus.

                    <h4>General Rules</h4>
                    Debate should be lively but also constructive and respectful.
                    Don't incite hatred on the basis of race, religion, gender, nationality or sexuality or other personal characteristic.
                    Don't swear, use hate-speech or make obscene or vulgar comments.
                    Don't break the law. This includes libel, condoning illegal activity and contempt of court (comments which might affect the outcome of an approaching court case).
                    Don't engage in 'spamming'. Don’t advertise products or services.
                    Don't impersonate or falsely claim to represent a person or organisation.
                    Protect your privacy and that of others. Please don’t post private addresses, phone numbers, email addresses or other online contact details.
                    Stay on-topic. Please don't post messages that are unrelated to the topic.
                    Comments/Content/Views on bbarters.com are moderated before going live. If a comment contravenes the safety rules it will not be published or will be removed from the site.

                    <h3>Content disclaimer</h3>

                    Views expressed by users are theirs alone and do not represent the views of bbarters.com.

                    <h3>Copyright and neighbouring rights</h3>

                    You own the copyright in your postings, articles and pictures, but you also agree to grant bbarters.com a perpetual, royalty-free, non-exclusive, sublicenseable right and license to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, perform, play, and exercise all copyright and publicity rights with respect to any such work worldwide and/or to incorporate it in other works in any media now known or later developed for the full term of any rights that may exist in such content.
                    If you do not wish to grant such rights to the bbarters.com, it is suggested that you do not submit your comment to this site.

                    You should remember that you are legally responsible for what you write. By submitting any content you undertake to indemnify the bbarters.com against any liability arising from breach of confidentiality or copyright, or any obscene, defamatory, seditious, blasphemous or other actionable statement you may make.
                    The copying and use of the bbarters.com logo and other bbarters.com-related logos is not permitted without prior approval of the bbarters.com.

                    <h3>Virus protection</h3>

                    The site operators make every effort to check and test material at all stages of production. It is always wise for users to run an anti virus program on all material downloaded from the internet.
                    bbarters.com cannot accept any responsibility for any loss, disruption or damage to your data or your computer system which may occur whilst using material from the bbarters.com website.

                    <h3>Your privacy</h3>

                    Cookies are pieces of data that are often created when you visit a website and are stored in the cookie directory of your own computer.
                    Cookies are used to store a session ID which allows you to log-in and make comments. No personal information is stored in the Cookie.
                    Other websites linked from this site are not covered by this privacy policy.
                    bbarters.com does require a user to enter a name and working email address in order to post a comment on this blog. This information is securely stored and will not be passed on to any third parties.

                    <h3>Links to and from other websites</h3>

                    bbarters.com is not responsible for the contents or reliability of the external websites and does not necessarily endorse the views expressed within them.
                    Links to external sites should not be taken as endorsement of any kind. We cannot guarantee that these links will work all of the time and we have no control over the availability of the linked pages.
                    bbarters.com encourages users to establish hypertext links to the site. You do not have to ask permission to link directly to pages hosted on the website. We do not object to you linking directly to our information, but you should obtain permission if you intend to use our logo.
                    </p>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="refreshed" value="no">
<script src="{{asset('js/reload.js')}}"></script>

<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrapValidator.min.js')}}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="{{asset('js/pages/getTweeple.js')}}"></script>
</body>
</html>