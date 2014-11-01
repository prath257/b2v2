<?php

    //AuthController
    Route::get('/',array('as'=>'index','uses'=>'AuthController@getIndex'));
    Route::post('login',array('as'=>'login','before'=>'csrf','uses'=>'AuthController@postLogin'));
    Route::post('signup',array('as'=>'signup','before'=>'csrf','uses'=>'AuthController@postSignup'));
    Route::get('/activate/{id}',array('as'=>'activate','uses'=>'AuthController@getActivation'));
    Route::get('/signout',array('as'=>'signout','uses'=>'AuthController@getLogout'));
    Route::post('forgotPassword',array('as'=>'forgotPassword','uses'=>'AuthController@forgotPassword'));
    Route::get('forgotPassword/{link}',array('as'=>'forgotPassword','uses'=>'AuthController@getforgotPassword'));
    Route::post('postResetPassword',array('as'=>'postResetPassword','uses'=>'AuthController@postResetPassword'));
    Route::post('checkFpLink',array('as'=>'checkFpLink','uses'=>'AuthController@checkFpLink'));

    //Set isOnline to false when any window is closed
    Route::post('removeIsOnline',array('as'=>'remove.is.online','uses'=>'AuthController@removeIsOnline'));


    //AjaxController
    Route::post('/checkUsername','AjaxController@checkUsername');
	Route::post('saveNewName','AjaxController@saveNewName');
	Route::post('getSuggestions','AjaxController@getSuggestions');
    Route::post('/checkEmail','AjaxController@checkEmail');


    //HomeController
    Route::get('/home',array('as'=>'home','before'=>'auth','uses'=>'HomeController@getHome'));
    Route::get('signup/{id}',array('as'=>'inviteeSignup','uses'=>'HomeController@getInviteeSignup'));
    Route::get('user/{username}',array('as'=>'user','uses'=>'HomeController@getUser'));


    //Review Content
    Route::get('reviewArticle/{articleId}', array('as'=>'reviewArticle', 'before'=>'auth', 'uses'=>'HomeController@getReviewArticle'));
    Route::get('reviewBlogBook/{blogBookId}', array('as'=>'reviewBlogBook', 'before'=>'auth', 'uses'=>'HomeController@getReviewBlogBook'));
    Route::get('review/{reviewId}', array('as'=>'review','before'=>'auth','uses'=>'HomeController@getReview'));
    Route::post('articleReview', array('as'=>'articleReview','uses'=>'HomeController@postArticleReview'));
    Route::post('blogBookReview', array('as'=>'blogBookReview','uses'=>'HomeController@postBlogBookReview'));
    Route::post('reviewBlogBook', array('as'=>'reviewBlogBook','uses'=>'HomeController@reviewBlogBook'));

    //Routes for subscribing functions
    Route::post('addSubscribe',array('as'=>'add.Subscribe','uses'=>'HomeController@addSubscribe'));
    Route::post('unSubscribe',array('as'=>'un.Subscribe','uses'=>'HomeController@unSubscribe'));
    Route::post('blockUnblockSubscriber',array('as'=>'blockUnblock.Subscriber','uses'=>'HomeController@blockUnblockSubscriber'));

    //IFC Manager
    Route::post('invite',array('as'=>'invite','uses'=>'HomeController@postInvite'));
    Route::post('transfer',array('as'=>'transfer','uses'=>'HomeController@postTransfer'));

    //Notifications
    Route::get('getNotification',array('as'=>'notification.get','uses'=>'HomeController@showNotification'));
    Route::post('closeNotification',array('as'=>'close.Notification','uses'=>'HomeController@closeNotification'));


    //Profile Controller
    Route::get('profile',array('as'=>'profile','before'=>'auth','uses'=>'ProfileController@getProfile'));
    Route::get('profileBuilder',array('as'=>'buildProfile','before'=>'auth','uses'=>'ProfileController@buildProfile'));
    Route::post('profileBuilder',array('as'=>'createProfile','before'=>'auth','uses'=>'ProfileController@postProfileBuilder'));
    Route::post('createProfile',array('as'=>'create.Profile','uses'=>'ProfileController@createProfile'));
    Route::post('saveAbout',array('as'=>'about.Profile','uses'=>'ProfileController@saveAbout'));
    Route::post('saveInterests',array('as'=>'interests.Profile','uses'=>'ProfileController@saveInterests'));
    Route::post('settings',array('as'=>'settings','uses'=>'ProfileController@getSettings'));
    Route::post('editProfilePic',array('as'=>'editProfilePic','before'=>'auth','uses'=>'ProfileController@postEditProfilePic'));
    Route::post('editProfileTune',array('as'=>'editProfileTune','before'=>'auth','uses'=>'ProfileController@postEditProfileTune'));
    Route::post('/aboutYou',array('as'=>'editAbout','before'=>'auth','uses'=>'ProfileController@postEditAboutYou'));
    Route::post('/editInterests',array('as'=>'editInterests','before'=>'auth','uses'=>'ProfileController@postEditInterests'));
    Route::post('editWallPic',array('as'=>'edit.WallPic','before'=>'auth','uses'=>'ProfileController@editWallPic'));
    Route::post('getWallpicBack',array('as'=>'cancel.editWallPic','uses'=>'ProfileController@postWallpicBack'));
    Route::post('removeWallpic',array('as'=>'remove.Wallpic','uses'=>'ProfileController@removeWallpic'));
    Route::post('showContent/{interest}/{user}',array('as'=>'showContent','uses'=>'ProfileController@showContent'));
    Route::post('getIFCs', array('as'=>'getIFCs', 'uses'=>'ProfileController@getIFCs'));
    Route::post('manageInterests', array('as'=>'manageInterests', 'uses'=>'ProfileController@manageInterests'));
    //Route to update online/offline when another user visits the user's profile
    Route::post('getStatus',array('as'=>'get.status','uses'=>'ProfileController@getStatus'));
    Route::post('saveNewWallPic', array('as'=>'saveNewWallPic', 'uses'=>'ProfileController@saveNewWallPic'));
    Route::post('primaryBuilder',array('as'=>'primaryBuilder', 'uses'=>'ProfileController@primaryBuilder'));

    //FriendsController - Friends
    Route::post('addFriend/{id}',array('as'=>'add.Friends','uses'=>'FriendsController@addFriend'));
    Route::get('showFriends',array('as'=>'showFriends','before'=>'auth','uses'=>'FriendsController@getFriends'));
    Route::post('acceptFriend/{id}',array('as'=>'accept.Friends','uses'=>'FriendsController@acceptFriend'));
    Route::post('declineFriend/{id}',array('as'=>'decline.Friends','uses'=>'FriendsController@declineFriend'));
    Route::post('deleteFriend/{id}',array('as'=>'delete.Friends','uses'=>'FriendsController@deleteFriend'));
    Route::post('cancelRequest/{id}',array('as'=>'delete.Friends','uses'=>'FriendsController@cancelRequest'));


    //QAController - Questions, About
    //Question
    Route::post('QnA/{userId}', array('as' => 'QnA', 'uses' => 'QAController@getQnA'));
    Route::post('postQuestion',array('as'=>'post.Question','uses'=>'QAController@postQuestion'));
    Route::post('postAnswer',array('as'=>'post.Answer','uses'=>'QAController@postAnswer'));
    Route::post('declineAnswer',array('as'=>'decline.Answer','uses'=>'QAController@declineAnswer'));
    Route::post('getDescription', array('as'=>'getDescription','uses'=>'QAController@getDescription'));
    Route::post('getAnswer', array('as'=>'getAnswer','uses'=>'QAController@getAnswer'));
    Route::post('getAnswerBox', array('as'=>'getAnswerBox','uses'=>'QAController@getAnswerBox'));
    //
    Route::post('about/{id}', array('as' => 'about', 'uses' => 'QAController@getAbout'));
    Route::post('postAboutText',array('as'=>'post.aboutText','uses'=>'QAController@postAboutText'));
    Route::post('acceptAbout',array('as'=>'accept.aboutText','uses'=>'QAController@postAcceptAbout'));
    Route::post('declineAbout',array('as'=>'decline.aboutText','uses'=>'QAController@postDeclineAbout'));
    Route::post('getUsersApprovedAbout', array('as' => 'get.users.approved.about', 'uses' => 'QAController@getUsersApprovedAbout'));

    //ChatController
    Route::post('submitChatRequest',array('as'=>'submit.chat.request','uses'=>'ChatController@submitChatRequest'));
    Route::post('acceptChat',array('as'=>'accept.chat','uses'=>'ChatController@acceptChat'));
    Route::post('declineChat',array('as'=>'decline.chat','uses'=>'ChatController@declineChat'));
    Route::post('sendMessage',array('as'=>'send.message','uses'=>'ChatController@sendMessage'));
    Route::post('retrieveChatData',array('as'=>'retrieve.chat.data','uses'=>'ChatController@retrieveChatData'));
    Route::post('getChatData',array('as'=>'get.chat.data','uses'=>'ChatController@getChatData'));
    Route::post('getChatLink',array('as'=>'get.chat.link','uses'=>'ChatController@getChatLink'));
    Route::post('completeChat',array('as'=>'complete.chat','uses'=>'ChatController@completeChat'));
    Route::post('isTypingTrue',array('as'=>'is.typing.true','uses'=>'ChatController@isTypingTrue'));
    Route::post('isTypingFalse',array('as'=>'is.typing.false','uses'=>'ChatController@isTypingFalse'));
    Route::post('retrieveIsTyping',array('as'=>'retrieve.is.typing','uses'=>'ChatController@retrieveIsTyping'));
    Route::post('getSecondPartyName',array('as'=>'get.second.party.name','uses'=>'ChatController@getSecondPartyName'));
    Route::post('checkNewMessages',array('as'=>'check.new.messages','uses'=>'ChatController@checkNewMessages'));
    Route::post('loginUser',array('as'=>'login.user','uses'=>'ChatController@loginUser'));
    Route::post('checkClosedChats',array('as'=>'check.closed.chats','uses'=>'ChatController@checkClosedChats'));
    Route::post('getSecondPartyProfilePic',array('as'=>'get.second.party.profile.pic','uses'=>'ChatController@getSecondPartyProfilePic'));
    Route::post('retrieveOngoingChats',array('uses'=>'ChatController@retrieveOngoingChats'));


   //BlogController (Articles)
    Route::get('readArticle/{articleId}', array('as'=>'article','before'=>'auth','uses'=>'BlogController@getArticle'));
    Route::get('articlePreview/{articleId}', array('as'=>'articlePreview','uses'=>'previewController@getArticlePreview'));
    Route::get('articleDashboard', array('as'=>'articleDashboard','before'=>'auth','uses'=>'BlogController@getDashboard'));
    Route::post('articleDashboard', array('as'=>'postArticleDashboard','before'=>'csrf','uses'=>'BlogController@postArticleDashboard'));
    Route::post('createArticle',array('as'=>'postArticle','uses'=>'BlogController@postArticle'));
    Route::post('deleteArticle/{id}',array('as'=>'deleteArticle','before'=>'auth','uses'=>'BlogController@deleteArticle'));
    Route::get('editArticle/{articleId}',array('as'=>'editArticle','before'=>'auth','uses'=>'BlogController@getEditArticle'));
    Route::post('editArticle',array('as'=>'editArticle','uses'=>'BlogController@editArticle'));
    Route::get('articlePreviewIframe/{articleId}', array('as'=>'articlePreviewIframe','uses'=>'BlogController@getArticlePreviewIframe'));


    //BookController (BlogBooks)
    Route::get('blogBookDashboard', array('as'=>'blogBookDashboard','before'=>'auth','uses'=>'BookController@getBlogBookDashboard'));
    Route::post('blogBookDashboard', array('as'=>'postBlogBookDashboard','before'=>'csrf','uses'=>'BookController@postBlogBookDashboard'));
    Route::get('newChapter/{blogBookId}', array('as'=>'newChapter','before'=>'auth','uses'=>'BookController@getNewChapter'));
    Route::post('createChapter',array('as'=>'postChapter','uses'=>'BookController@postChapter'));
    Route::get('blogBookPreview/{blogBookId}', array('as'=>'blogBookPreview','uses'=>'previewController@getBlogBookPreview'));
    Route::get('previewBlogBook/{blogBookId}', array('as'=>'previewBlogBook','uses'=>'BookController@getPreviewBlogBook'));
    Route::get('blogBook/{blogBookId}', array('as'=>'blogBook','before'=>'auth','uses'=>'BookController@getBlogBook'));
    Route::post('deleteBlogBook',array('as'=>'deleteBlogBook','uses'=>'BookController@deleteBlogBook'));
    Route::get('editBlogBook/{blogBookId}',array('as'=>'editBlogBook','before'=>'auth','uses'=>'BookController@getEditBlogBook'));
    Route::post('editBlogBook',array('as'=>'editBlogBook','uses'=>'BookController@postEditBlogBook'));
    Route::post('deleteChapter',array('as'=>'deleteChapter','uses'=>'BookController@deleteChapter'));
    Route::get('editChapter/{chapterId}', array('as'=>'editChapter','before'=>'auth','uses'=>'BookController@getEditChapter'));
    Route::post('updateChapter', array('as'=>'updateChapter', 'uses'=>'BookController@postUpdateChapter'));
    Route::post('getBlogbookContent', array('as'=>'getBlogbookContent', 'uses'=>'BookController@getBlogbookContent'));
    Route::post('getBookChapterList',array('as'=>'getBookChapterList', 'uses'=>'BookController@getBookChapterList'));

    //CollaborationsController
    Route::get('collaborationsDashboard', array('as'=>'collaborationsDashboard','before'=>'auth','uses'=>'CollaborationsController@getDashboard'));
    Route::post('newCollaboration', array('as'=>'newCollaboration','before'=>'csrf','uses'=>'CollaborationsController@postNewCollaboration'));
    Route::get('collaborationNewChapter/{collaborationId}', array('as'=>'collaborationNewChapter','before'=>'auth','uses'=>'CollaborationsController@getNewChapter'));
    Route::post('collaborationCreateChapter',array('as'=>'collaborationCreateChapter','uses'=>'CollaborationsController@postChapter'));
    Route::get('collaboration/{collaborationId}', array('as'=>'collaboration','before'=>'auth','uses'=>'CollaborationsController@getCollaboration'));
    Route::post('deleteCollaboration',array('as'=>'deleteCollaboration','uses'=>'CollaborationsController@deleteCollaboration'));
    Route::post('inviteContributor',array('as'=>'inviteContributor','uses'=>'CollaborationsController@inviteContributor'));
    Route::get('acceptCollaboration/{link}/{collaborationId}', array('as'=>'acceptCollaboration','before'=>'auth','uses'=>'CollaborationsController@acceptCollaboration'));
    Route::post('deleteContribution', array('as'=>'deleteContribution', 'uses'=>'CollaborationsController@deleteContribution'));
    Route::get('collaborationSettings/{collaborationId}', array('as'=>'collaborationSettings','before'=>'auth','uses'=>'CollaborationsController@getCollaborationSettings'));
    Route::post('editCollaboration', array('as' => 'editCollaboration', 'uses' => 'CollaborationsController@postEditCollaboration'));
    Route::post('deleteContributor',array('as'=>'deleteContributor','uses'=>'CollaborationsController@deleteContributor'));
    Route::post('deleteCollaborationChapter',array('as'=>'deleteCollaborationChapter','uses'=>'CollaborationsController@deleteCollaborationChapter'));
    Route::get('editCollaborationChapter/{chapterId}',array('as'=>'editCollaborationChapter','before'=>'auth','uses'=>'CollaborationsController@getEditCollaborationChapter'));
    Route::post('updateCollaborationChapter', array('as'=>'updateCollaborationChapter', 'uses'=>'CollaborationsController@postUpdateCollaborationChapter'));
    Route::get('editCollaborationChapters/{collaborationId}', array('as'=>'editCollaborationChapters','before'=>'auth','uses'=>'CollaborationsController@getEditCollaborationChapters'));
    Route::get('collaborationPreview/{collaborationId}', array('as'=>'collaborationPreview','uses'=>'previewController@getCollaborationPreview'));
    Route::get('previewCollaboration/{collaborationId}', array('as'=>'previewCollaboration','uses'=>'CollaborationsController@getPreviewCollaboration'));
    Route::post('request2contribute',array('as'=>'request2contribute','uses'=>'CollaborationsController@request2contribute'));
    Route::get('acceptContributionRequest/{link}',array('as'=>'acceptContributionRequest','before'=>'auth','uses'=>'CollaborationsController@acceptContributionRequest'));
    Route::get('contributionApprove/{id}',array('as'=>'contributionApprove','before'=>'auth','uses'=>'CollaborationsController@contributionApprove'));
    Route::post('doneEditing', array('as' => 'doneEditing', 'uses' => 'CollaborationsController@doneEditing'));
    Route::post('approveVerdict',array('as'=>'approveVerdict','uses'=>'CollaborationsController@approveVerdict'));
    Route::get('contributionEditApprove/{id}',array('as'=>'contributionEditApprove','before'=>'auth','uses'=>'CollaborationsController@contributionEditApprove'));
    Route::post('approveEditVerdict',array('as'=>'approveVerdict','uses'=>'CollaborationsController@approveEditVerdict'));
    Route::post('getCollaborationContent', array('as'=>'getCollaborationContent', 'uses'=>'CollaborationsController@getCollaborationContent'));
    Route::post('getCollabChapterList',array('as'=>'getCollabChapterList', 'uses'=>'CollaborationsController@getCollabChapterList'));


    //ResourceControllers (Resources)
    Route::get('resourceDashboard', array('as'=>'resourceDashboard','before'=>'auth','uses'=>'ResourceController@getDashboard'));
    Route::get('resource/{resourceId}', array('as'=>'resource','uses'=>'previewController@getResourcePreview'));
    Route::post('sym140Nb971wzb4284/{resourceId}', array('before'=>'auth','uses'=>'ResourceController@downloadResource'));
    Route::get('downloadResource/{resourceId}', array('as'=>'downloadResource','before'=>'auth','uses'=>'ResourceController@startDownload'));
    Route::post('deleteResource',array('as'=>'deleteResource','uses'=>'ResourceController@deleteResource'));
    Route::post('createResource', array('as'=>'postResource','uses'=>'ResourceController@createResource'));
    Route::get('resourceIframe/{resourceId}', array('as'=>'resourceIframe','uses'=>'ResourceController@getResourceIframe'));


    //MediaController (MediaSeries)
    Route::post('uploadMedia',array('as'=>'post.media','uses'=>'MediaController@uploadMedia'));
    Route::get('mediaDashboard',array('as'=>'mediaDashboard','before'=>'auth','uses'=>'MediaController@getMedia'));
    Route::get('newPublicMedia',array('as'=>'newPublicMedia','before'=>'auth','uses'=>'MediaController@newPublicMedia'));
    Route::post('deleteMedia',array('as'=>'delete.media','uses'=>'MediaController@deleteMedia'));
    Route::post('uploadPublicMedia',array('uses'=>'MediaController@uploadPublicMedia'));
    Route::post('getMediaDetails',array('uses'=>'MediaController@getMediaDetails'));
    Route::post('editPublicMedia',array('uses'=>'MediaController@editPublicMedia'));
    Route::get('mediaPreview/{id}',array('as'=>'mediaPreview','uses'=>'MediaController@getMediaPreview'));
    Route::get('media/{id}',array('as'=>'media', 'before' => 'auth', 'uses'=>'MediaController@getMediaDummy')); //Dummy view of mediaPreview with an auth filter
    Route::post('viewMedia',array('uses'=>'MediaController@viewMedia'));

   //SettingsController (AccountSettings)
	Route::post('saveAccountSettings',array('as'=>'saveAccountSettings','uses'=>'SettingsController@saveAccountSettings'));
	Route::post('resetPassword',array('as'=>'resetPassword','uses'=>'SettingsController@resetPassword'));

    //this is the route for myreadings
    Route::get('readings',array('as'=>'readings','before'=>'auth','uses'=>'HomeController@getMyReadings'));


    //these are the routes for DataTables
    Route::get('getArticleData', array('as'=>'getArticleData', 'uses'=>'DataTableController@getArticleDatatable'));
    Route::get('getMediaData', array('as'=>'getMediaData', 'uses'=>'DataTableController@getMediaDatatable'));
    Route::get('getResourceData', array('as'=>'getResourceData', 'uses'=>'DataTableController@getResourceDatatable'));
    Route::get('getBookData', array('as'=>'getBookData', 'uses'=>'DataTableController@getBookDatatable'));
    Route::get('getChapterData/{bid}', array('as'=>'getChapterData', 'uses'=>'DataTableController@getChapterDatatable'));
    Route::get('getMyArticlesData', array('as'=>'getMyArticlesData', 'uses'=>'DataTableController@getMyArticlesDatatable'));
    Route::get('getMyBooksData', array('as'=>'getMyBooksData', 'uses'=>'DataTableController@getMyBooksDatatable'));
    Route::get('getMyCollaborationsData', array('as'=>'getMyCollaborationsData', 'uses'=>'DataTableController@getMyCollaborationsDatatable'));


    Route::get('getCollaborationData', array('as'=>'getCollaborationData', 'uses'=>'DataTableController@getCollaborationDatatable'));
    Route::get('getContributionData', array('as'=>'getContributionData', 'uses'=>'DataTableController@getContributionDatatable'));
    Route::get('getCollaborationChapterData/{cid}', array('as'=>'getCollaborationChapterData', 'uses'=>'DataTableController@getCollaborationChapterDatatable'));
    Route::get('getCollaborationContributorData/{cid}', array('as'=>'getCollaborationContributorData', 'uses'=>'DataTableController@getCollaborationContributorDatatable'));
    Route::get('getHisCollaborationData/{userId}/{interestId}', array('as'=>'getHisCollaborationData', 'uses'=>'DataTableController@getHisCollaborationDatatable'));
    Route::get('getHisContributionData/{userId}/{interestId}', array('as'=>'getHisContributionData', 'uses'=>'DataTableController@getHisContributionDatatable'));


    Route::get('getHisArticlesData/{userId}/{interestId}', array('as'=>'getHisArticlesData', 'uses'=>'DataTableController@getHisArticlesDatatable'));
    Route::get('getHisBooksData/{userId}/{interestId}', array('as'=>'getHisBooksData', 'uses'=>'DataTableController@getHisBooksDatatable'));
    Route::get('getHisResourcesData/{userId}/{interestId}', array('as'=>'getHisResourcesData', 'uses'=>'DataTableController@getHisResourcesDatatable'));

    Route::get('getFriendList',array('as'=>'getFriendList', 'uses'=>'DataTableController@getFriendListDatatable'));
    Route::get('getRequestList',array('as'=>'getRequestList', 'uses'=>'DataTableController@getRequestListDatatable'));
    Route::get('getPendingList',array('as'=>'getPendingList', 'uses'=>'DataTableController@getPendingListDatatable'));
    Route::get('getSubscribersList',array('as'=>'getSubscribersList', 'uses'=>'DataTableController@getSubscribersListDatatable'));
    Route::get('getSubscriptionsList',array('as'=>'getSubscriptionsList', 'uses'=>'DataTableController@getSubscriptionsListDatatable'));


    Route::get('unansweredQuestions/{userId}', array('as' => 'unansweredQuestions', 'uses' => 'DataTableController@getUnansweredQuestions'));
    Route::get('answeredQuestions/{userId}', array('as' => 'answeredQuestions', 'uses' => 'DataTableController@getAnsweredQuestions'));

    //this is the route for getting the chart data
    Route::post('getArticleChartData', array('as'=>'getArticleChartData', 'uses'=>'GraphicsController@getArticleChartData'));
    Route::post('getBooksChartData', array('as'=>'getBooksChartData', 'uses'=>'GraphicsController@getBooksChartData'));
    Route::post('getCollaborationsChartData', array('as'=>'getCollaborationsChartData', 'uses'=>'GraphicsController@getCollaborationsChartData'));
    Route::post('getResourcesChartData', array('as'=>'getResourcesChartData', 'uses'=>'GraphicsController@getResourcesChartData'));
    Route::post('getQuizChartData', array('as'=>'getQuizChartData', 'uses'=>'GraphicsController@getQuizChartData'));
    Route::post('getUserChartData', array('as'=>'getUserChartData', 'uses'=>'GraphicsController@getUserData'));
    Route::post('getChatChartData', array('as'=>'getChatChartData', 'uses'=>'GraphicsController@getChatData'));
    Route::post('getChatAuditChartData', array('as'=>'getChatAuditChartData', 'uses'=>'GraphicsController@getChatAuditData'));



    //these are the content notifications on homepage
    Route::post('getFriendsContentNotification', array('as'=>'friendsContentNotification', 'uses'=>'DataTableController@friendsNotificationData'));
    Route::get('categorical',array('as'=>'categorical','uses'=>'DataTableController@getCategorical'));
    Route::post('getCategoryContentNotification/{id}/{type}', array('as'=>'categoryContentNotification', 'uses'=>'DataTableController@categoryNotificationData'));


    //these are the routes for bugs and suggestions
    Route::get('reportBug',array('as'=>'reportBug','before'=>'auth','uses'=>'BaseController@getReportBug'));
    Route::post('reportBug',array('as'=>'postReportBug','uses'=>'BaseController@postReportBug'));
    Route::get('respondToBug/{bugId}',array('as'=>'respondToBug','before'=>'auth','uses'=>'BaseController@getRespondToBug'));
    Route::post('respondToBug',array('as'=>'respondToBug','uses'=>'BaseController@postRespondToBug'));

    //these are for twitter login
    Route::get('twauth/{auth?}',array('as'=>'twitterLogin','uses'=>'AuthController@postTwitterLogin')) ;
    Route::get('firstTweeple/{tid}',array('as'=>'firstTweeple','uses'=>'AuthController@getTweeple'));
    Route::post('/twsignup',array('as'=>'twsignup','before'=>'csrf','uses'=>'AuthController@postTweepleSignup'));


    //these are for facebook login
    Route::get('fbauth/{auth?}',array('as'=>'facebookLogin','uses'=>'AuthController@postFbLogin')) ;
    Route::get('firstFacebook/{fid}',array('as'=>'firstFacebook','uses'=>'AuthController@getFirstFacebook'));
    Route::post('/fbSignup',array('as'=>'fbSignup','before'=>'csrf','uses'=>'AuthController@postFacebookSignup'));

    //these are for google login
    Route::get('gauth/{auth?}',array('as'=>'googleLogin','uses'=>'AuthController@postGoogleLogin')) ;
    Route::get('firstGoogle/{fid}',array('as'=>'firstGoogle','uses'=>'AuthController@getFirstGoogle'));
    Route::post('/googleSignup',array('as'=>'googleSignup','before'=>'csrf','uses'=>'AuthController@postGoogleSignup'));

    //These are the chat routes
    Route::get('chats', array('as'=>'chats','before'=>'auth','uses'=>'HomeController@getOngoingChats'));
    Route::get('chats/{link}', array('as'=>'chatsLink','before'=>'auth','uses'=>'HomeController@getOngoingChatsLink'));
    Route::post('refreshOnlineFriends', array('as'=>'refreshOnlineFriends', 'uses'=>'ChatController@getOnlineContacts'));
    Route::post('getChatNotifications',array('as'=>'chat.notification.get','uses'=>'HomeController@showChatNotifications'));


    //these are routes for polls
    Route::get('pollDashboard',array('as'=>'pollDashboard','before'=>'auth','uses'=>'PollController@getPollDashboard'));
    Route::post('createPoll',array('as'=>'createPoll','before'=>'csrf','uses'=>'PollController@createPoll'));
    Route::get('poll/{id}', array('as'=>'poll','uses'=>'PollController@showPoll'));
    Route::post('submitPoll', array('as'=>'submitPoll','before'=>'auth','uses'=>'PollController@submitPoll'));
    Route::post('deletePoll/{id}', array('as'=>'deletePoll','before'=>'auth','uses'=>'PollController@deletePoll'));
    Route::post('closePoll/{id}', array('as'=>'closePoll','before'=>'auth','uses'=>'PollController@closePoll'));
    Route::post('getResult/{id}',array('as'=>'getPollResult','before'=>'auth','uses'=>'PollController@getPollResult'));


    //Polls Datatables
    Route::get('getMyPollsData', array('as'=>'getMyPollsData', 'uses'=>'DataTableController@getMyPollsDatatable'));
    Route::get('getPublicPollsData', array('as'=>'getPublicPollsData', 'uses'=>'DataTableController@getPublicPollsDatatable'));
    Route::get('getFriendsPollsData', array('as'=>'getFriendsPollsData', 'uses'=>'DataTableController@getFriendsPollsDatatable'));
    Route::get('getSubscriptionPollsData', array('as'=>'getSubscriptionPollsData', 'uses'=>'DataTableController@getSubscriptionPollsDatatable'));


    //these are the routes for quiz
    Route::get('quizDashboard',array('as'=>'quizDashboard','before'=>'auth','uses'=>'QuizController@getQuizDashboard'));
    Route::get('newQuiz',array('as'=>'getNewQuiz','uses'=>'QuizController@getNewQuiz'));
    Route::post('newQuiz',array('as'=>'newQuiz','before'=>'csrf','uses'=>'QuizController@postNewQuiz'));
    Route::post('createQuiz',array('as'=>'createQuiz','before'=>'auth','uses'=>'QuizController@postCreateQuiz'));
    Route::get('quiz/{id}',array('as'=>'quiz','before'=>'auth','uses'=>'QuizController@getQuiz'));
    Route::post('checkAns',array('as'=>'checkAns','uses'=>'QuizController@checkAns'));
    Route::post('postQuizResults', array('as'=>'postQuizResults', 'uses'=>'QuizController@postQuizResults'));
    Route::post('deleteQuiz/{id}', array('as'=>'deleteQuiz','before'=>'auth','uses'=>'QuizController@deleteQuiz'));
    Route::post('closeQuiz/{id}', array('as'=>'closeQuiz','before'=>'auth','uses'=>'QuizController@closeQuiz'));
    Route::post('getQuizStats/{id}',array('as'=>'getQuizStats','before'=>'auth','uses'=>'QuizController@getQuizStats'));
    Route::get('quizPreview/{id}',array('as'=>'quizPreview','uses'=>'previewController@getQuizPreview'));
    Route::get('editQuiz/{id}', array('as' => 'editQuiz', 'before' => 'auth', 'uses' => 'QuizController@editQuiz'));
    Route::post('removeExistingQuestion', array('as' => 'removeExistingQuestion', 'uses' => 'QuizController@removeExistingQuestion'));
    Route::post('editExistingQuestion', array('as' => 'editExistingQuestion', 'uses' => 'QuizController@editExistingQuestion'));
    Route::post('updateQuizQuestion', array('as' => 'updateQuizQuestion', 'uses' => 'QuizController@updateQuizQuestion'));

    //Quiz Datatables
    Route::get('getMyQuizData', array('as'=>'getMyQuizData', 'uses'=>'DataTableController@getMyQuizDatatable'));
    Route::get('getPublicQuizData', array('as'=>'getPublicQuizData', 'uses'=>'DataTableController@getPublicQuizDatatable'));
    Route::get('getFriendsQuizData', array('as'=>'getFriendsQuizData', 'uses'=>'DataTableController@getFriendsQuizDatatable'));
    Route::get('getSubscriptionQuizData', array('as'=>'getSubscriptionQuizData', 'uses'=>'DataTableController@getSubscriptionQuizDatatable'));
    Route::get('getQuizTakersData/{id}', array('as'=>'getQuizTakersData', 'uses'=>'DataTableController@getQuizTakersDatatable'));
    Route::get('getExistingQuizQuestionsData/{id}', array('as'=>'getExistingQuizQuestionsData', 'uses'=>'DataTableController@getExistingQuizQuestionsDatatable'));

   //New IFRame views for friendList and Subsscribers List
    Route::post('friendList', array('as'=>'friendList', 'uses'=>'ProfileController@getFriendList'));
    Route::post('subscribersList', array('as'=>'subscribersList', 'uses'=>'ProfileController@getSubscribersList'));

   //this is the route for batch jobs
    Route::get('clearAuth',array('as'=>'clearAuth', 'uses'=>'AuthController@clearSessionData'));

    Route::post('getTypes',array('as'=>'getTypes','uses'=>'BlogController@getTypes'));
    Route::post('getArticleTemplate',array('as'=>'getArticleTemplate','uses'=>'BlogController@getArticleTemplate'));

 /* Route::group(array('domain' => '{username}.b2.com'), function()
        {
            Route::get('/', function($username)
            {
                /*$user=User::where('username','=',$username)->first();
                $userProfile=$user->profile()->first();
                $wallpics=$user->wall()->get();
                $interests=$user->interestedIn()->get();
                $oldpics=$user->getTrivia()->get();
                $aboutHim=$user->about()->get();
                $questions=$user->questionsAskedToUser()->where('answer','!=','null')->orderBy('updated_at','DESC')->paginate(2);
                $currentTime = new DateTime();
                $lastSeen = $user->updated_at;
                $form = $currentTime->diff($lastSeen);
                if($form->i>4)
                {
                    $user->isOnline=false;
                    $user->save();
                }
                $data=array('wallpics'=>$wallpics,'profile'=>$userProfile,'interests'=>$interests,'trivia'=>$oldpics,'user'=>$user,'about'=>$aboutHim,'questions'=>$questions);
                return View::make('dummyProfile',$data);
                return $username;
            });
        });*/


    Route::get('createDatabase',function()
    {
        Artisan::call('migrate');
        return "Tables there";
    });

Route::get('test',function()
{
    return View::make('test');
});

//DataTables for Writings
Route::get('getResourceWritingData', array('as'=>'getResourceWritingData', 'uses'=>'DataTableController@getResourceWritingDatatable'));
Route::get('getMediaWritingData', array('as'=>'getMediaWritingData', 'uses'=>'DataTableController@getMediaWritingDatatable'));

Route::get('earnIFCs', array('as'=>'earnIFCs', 'before' => 'auth', 'uses'=>'HomeController@earnIFCs'));

//Ajax calls to load data on content.blade.php (AjaxController)
    Route::post('getContentArticles',array('as'=>'getContentArticles','uses'=>'AjaxController@getContentArticles'));
    Route::post('getContentBooks',array('as'=>'getContentBooks','uses'=>'AjaxController@getContentBooks'));
    Route::post('getContentResources',array('as'=>'getContentResources','uses'=>'AjaxController@getContentResources'));
    Route::post('getContentPollsNQuizes',array('as'=>'getContentPollsNQuizes','uses'=>'AjaxController@getContentPollsNQuizes'));

Route::post('loadMoreFriends', array('as' => 'loadMoreFriends', 'uses' => 'FriendsController@loadMoreFriends'));
Route::post('loadMoreSubscribers', array('as' => 'loadMoreSubscribers', 'uses' => 'FriendsController@loadMoreSubscribers'));
Route::post('loadMoreSubscriptions', array('as' => 'loadMoreSubscriptions', 'uses' => 'FriendsController@loadMoreSubscriptions'));

Route::get('addInterestsToWallpics', array('as' => 'addInterestsToWallpics', 'uses' => 'BaseController@addInterestsToWallpics'));

Route::get('saveDefaultInterests', array('as' => 'saveDefaultInterests', 'uses' => 'BaseController@saveDefaultInterests'));


//Events
Route::get('createEvent', array('as' => 'createEvent', 'before' => 'auth', 'uses' => 'EventsController@getCreateEvent'));
Route::post('createEvent', array('as' => 'postCreateEvent', 'before' => 'csrf', 'uses' => 'EventsController@postCreateEvent'));
Route::get('event/{id}', array('as' => 'event', 'uses' => 'EventsController@getEvent'));
Route::get('updateEvent/{id}', array('as' => 'updateEvent', 'before' => 'auth', 'uses' => 'EventsController@getUpdateEvent'));
Route::post('updateEvent', array('as' => 'postUpdateEvent', 'uses' => 'EventsController@postUpdateEvent'));
Route::post('deleteEvent', array('as' => 'deleteEvent', 'uses' => 'EventsController@deleteEvent'));
Route::post('toggleEvent', array('as' => 'toggleEvent', 'uses' => 'EventsController@toggleEvent'));
Route::post('eventRegister', array('as' => 'eventRegister', 'uses' => 'EventsController@eventRegister'));
Route::post('cancelRegister', array('as' => 'cancelRegister', 'uses' => 'EventsController@cancelRegister'));
Route::get('attendeeList/{id}', array('as' => 'attendeeList', 'before'=>'auth', 'uses' => 'EventsController@getAttendeeList'));
Route::get('manageEvents', array('as' => 'manageEvents', 'before' => 'auth', 'uses' => 'EventsController@manageEvents'));
Route::get('myEvents', array('as' => 'myEvents', 'before' => 'auth', 'uses' => 'EventsController@myEvents'));
Route::post('mailMe', array('as' => 'mailMe', 'uses' => 'EventsController@mailMe'));
Route::post('showCategoryEvents', array('as' => 'showCategoryEvents', 'uses' => 'EventsController@showCategoryEvents'));
//Route::get('getHostedEvents', array('as'=>'getHostedEvents', 'uses'=>'DataTableController@getRegisteredEvents'));
//Route::get('getRegisteredEvents', array('as'=>'getRegisteredEvents', 'uses'=>'DataTableController@getRegisteredEvents'));


Route::get('ifcDeficit', array('as' => 'ifcDeficit', 'before' => 'auth', 'uses' => 'BaseController@getIFCDeficit'));
Route::post('loadMoreEvents', array('as' => 'loadMoreEvents', 'uses' => 'AjaxController@loadMoreEvents'));

Route::post('srFriends',array('as'=>'srFriends','uses'=>'FriendsController@searchFriends'));

Route::get('hathwayStopIt',array('uses'=>'BaseController@hathwayStopIt'));

Route::post('ifcModal/{ifcReq}', array('as' => 'ifcModal', 'before' => 'auth', 'uses' => 'TransactionController@getIfcModal'));

//for actionscontroller
Route::post('getActionData', array('as'=>'getActionData', 'uses'=>'AjaxController@getActionData'));

Route::post('notificationList',array('uses'=>'AjaxController@getNotification'));
Route::post('numberOfNotifications',array('uses' => 'AjaxController@getNumberOfNotification'));

Route::post('loadMoreActions',array('uses' => 'AjaxController@loadMoreActions'));

Route::post('searchAction',array('as' => 'searchAction','uses'=>'AjaxController@getSearchResults'));

Route::post('failedSearch',array('uses' => 'AjaxController@failedSearch'));

Route::get('ifcManager',array('as' => 'ifcManager','before' => 'auth', 'uses'=>'TransactionController@getIfcManager'));

Route::get('getIFCManagerData', array('as'=>'getIFCManagerData', 'uses'=>'DataTableController@getIFCManagerData'));

Route::post('submitProblemOnException',array('uses' => 'BaseController@submitProblemOnException'));
Route::get('reportException',array('as'=>'reportException','uses'=>'BaseController@getReportException'));
Route::get('respondToProblem/{userid}',array('as' => 'respondToProblem', 'before' => 'auth', 'uses' => 'BaseController@respondToProblem'));
Route::post('respondToProblem',array('uses' => 'BaseController@postResponceToProblem'));

//diary
Route::get('diary/{username}', array('as' => 'diary', 'before' => 'auth', 'uses' => 'DiaryController@getDiary'));
Route::post('getCalendar', array('uses' => 'DiaryController@getCalendar'));
Route::post('setDiaryAccess',array('as' => 'setDiaryAccess','uses'=>'DiaryController@setDiaryAccess'));
Route::post('getUsers',array('as'=>'getUsers','uses'=>'DiaryController@getUsers'));
Route::post('addSuser',array('as'=>'addSuser','uses'=>'DiaryController@addSuser'));
Route::post('delSuser',array('as'=>'delSuser','uses'=>'DiaryController@delSuser'));
Route::post('getSusers',array('as'=>'getSusers','uses'=>'DiaryController@getSusers'));
Route::post('saveDiary', array( 'uses'=>'DiaryController@saveDiary'));
Route::post('createDiary', array( 'uses'=>'DiaryController@createDiary'));
Route::post('deleteDiaryPost', array( 'uses'=>'DiaryController@deleteDiaryPost'));
Route::post('updateDiaryTitle', array( 'uses'=>'DiaryController@updateDiaryTitle'));
Route::post('getMonthlyDates', array('as'=>'getMonthlyDates', 'uses'=>'DiaryController@getMonthlyDates'));

Route::get('offline', array('uses' => 'BaseController@accidentialLogout'));

//recco
Route::post('post_recco', array('uses' => 'ReccoController@post_recco'));
Route::post('publish_recco', array('uses' => 'ReccoController@publish_recco'));
Route::post('loadRecco', array('uses' => 'ReccoController@loadRecco'));
Route::post('loadMyRecco', array('uses' => 'ReccoController@loadMyRecco'));
Route::post('incrementHits', array('uses' => 'ReccoController@incrementHits'));
Route::post('deleteRecco', array('uses' => 'ReccoController@deleteRecco'));
Route::post('searchRecco', array('uses' => 'ReccoController@searchRecco'));

//home data article bb collab
Route::post('article_write', array('uses' => 'AjaxController@article_write'));
Route::post('bb_write', array('uses' => 'AjaxController@bb_write'));
Route::post('collab_write', array('uses' => 'AjaxController@collab_write'));
Route::post('res_write', array('uses' => 'AjaxController@res_write'));
Route::post('poll_write', array('uses' => 'AjaxController@poll_write'));
Route::post('quiz_write', array('uses' => 'AjaxController@quiz_write'));
Route::post('media_write', array('uses' => 'AjaxController@media_write'));

