var wpApp = new angular.module( 'wpAngularTheme', ['ui.router', 'ngResource'] );





wpApp.controller('InfoCtrl', ['$scope', '$http', '$state',  '$stateParams', function( $scope, $http, $stateParams, $state) {
 //getting fooVal
    // var inReturn = $stateParams.inReturn; //getting barVal
    // //..
    // $scope.state = $state.current;
    // $scope.params = $stateParams; 
    
      $scope.UserList = $state.userInfoUserList; 
       $scope.UserWantList = $state.userInfoUserWantList;
       $scope.UserListStringify= JSON.stringify($scope.UserList);
       $scope.UserWantListStringify= JSON.stringify($scope.UserWantList);
       $scope.phpURL=appInfo.template_directory + 'templates/process.php';

    $scope.sendMessage = function( input ) {
      input.submit = true;
      var processUrl='http://localhost:8888/#!/submit';

      console.log(processUrl);
      // $http.post('process.php', {formData:angular.element.param(input)}).then(function(){console.log('HOLY SHIT IT SENT')});
      $http({
          method: 'POST',
          url: processUrl,
          data: {formData:angular.element.param(input)},
         headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      })
        .then( function(data) {
          if ( data.success ) {
            $scope.success = true;
            console.log('Holy Shit it sent');
          } else {
            $scope.error = true;
            console.log('Not this time. Try again')
          }
        } );



    }
 

}]);
wpApp.controller('SelectionCtrl', ['$scope', '$http','$state',  '$stateParams', function( $scope, $http, $state, $stateParams) {
 var makeModelJson=appInfo.template_directory + 'assets/js/makeModel.json';
  $http.get(makeModelJson).then(function(data) {
    $scope.makeModel=data.data;

  
    $scope.makes=[];
    $scope.models=[];
    $scope.years=[];
    $scope.types=[];
    $scope.userList=[];
    $scope.userWantList=[];
    $scope.selectedModel;
    $scope.selectedMake;
    $scope.comment;
    $scope.newItemAdded=true;
    $scope.AddItemShouldShow=false;
    $scope.UserWant;
    $scope.removeButtonShouldShow="false";
    $scope.removedItem;
    $scope.removeUserList=[];
    $scope.file;

            //this imports the types
  $scope.allTypes=[];
  for(var i=0;i<$scope.makeModel.length;i++){
    $scope.allTypes.push($scope.makeModel[i].type);

  }

    $scope.types=unique($scope.allTypes);
  $scope.updateType=function(typeselected) {
    $scope.thisType=typeselected;
    $scope.makes=[];

    for(i=0;i<$scope.makeModel.length;i++){
      
      if($scope.makeModel[i].type===typeselected) {
        $scope.makes.push($scope.makeModel[i].make);
        }
      $scope.makes=unique($scope.makes);
    }
  };

    function unique(someArray) {
      var o = {}, i, l = someArray.length, r = [];
      for(i=0; i<l;i+=1) {o[someArray[i]] = someArray[i];}
      for(i in o) {r.push(o[i]);}
      return r;
  }

    //updates the models in the array
  $scope.updateMake=function(makeselected) {
    $scope.selectedMake=makeselected;
    $scope.models=[];

    for(i=0;i<$scope.makeModel.length;i++){
      
      if($scope.makeModel[i].make===makeselected) {
        $scope.models.push($scope.makeModel[i].model);
      }

    }
    $scope.models=unique($scope.models);
    
  };

  $scope.updateModel=function(modelSelected) {
    for(i=0;i<$scope.models.length;i++){
      if($scope.models[i]===modelSelected){
      $scope.selectedModel=$scope.models[i];
        $scope.AddItemShouldShow=true;
      break;
      }
      
    }
  };
$scope.addFile = function() {
    var f = document.getElementById('file').files[0],
        r = new FileReader();

    r.onloadend = function(e) {
      var imgData = e.target.result;
      $scope.file=imgData;//send your binary data via $http or $resource or do anything else with it
    }

    r.readAsBinaryString(f);
    

}
$scope.makeComment = function(comment){
    $scope.comment=comment;
}
      //this updates the user data
  $scope.addItemTouserList=function() {
    for(var i=0;i<$scope.makeModel.length;i++){
      if($scope.makeModel[i].model===$scope.selectedModel&&$scope.makeModel[i].make===$scope.selectedMake){
        if($scope.comment!=null){
           $scope.makeModel[i].comment=$scope.comment;

        }

        $scope.userList.push($scope.makeModel[i]);
        
        // $scope.userList.push($scope.file);
        $scope.AddItemShouldShow=true;
        $scope.resetFormItems();
        break;
      }
      
    }
  };  
  
 
      
  $scope.updateUserWant=function(userWant){
    $scope.userWant=userWant;
  };    
        //this updates the user data
  $scope.addItemTouserWantList=function() {

      $scope.userWantList.push($scope.userWant);

  };  


  $scope.resetFormItems=function() {
    
    $scope.makes=[];
    $scope.models=[];
    $scope.selectedMake=null;
    $scope.selectedModel=null;
    var options = document.querySelectorAll('#typeSelect option');

      for (var i = 0, l = options.length; i < l; i++) {
      options[i].selected = options[i].defaultSelected;
      };
   document.getElementById('comment').value = "";
             // $scope.comment=null;
  };  

  $scope.addRemoveButton=function(indexItem){
    $scope.removeButtonShouldShow="true";
    $scope.removedItems.push(indexItem);
  };

  $scope.addToRemoveUserList=function(removedItem,checked){
   if(checked){
    $scope.removeUserList.push(removedItem);
    }else{$scope.removeUserList.remove(removedItem);}
  };

  $scope.removeItem=function(){
    for (var i = 0; i < $scope.userList.length+1; i++) { 
      for (var j = 0; j < $scope.removeUserList.length+1; j++) { 
        if($scope.userList[i]==$scope.removeUserList[j]){
          $scope.userList.splice(i, i+1);
          $scope.removeUserList.splice(j, j+1);
        };
  
       }; 

    };
    
    for (var k = 0; k < $scope.userWantList.length+1; k++) { 
      for (var j = 0; j < $scope.removeUserList.length+1; j++) { 
        if($scope.userWantList[k]==$scope.removeUserList[j]){
          $scope.userWantList.splice(k, k+1);
          $scope.removeUserList.splice(j, j+1);
        };
  
       }; 
       
    };
  };



   $scope.changeState=function(){
    $state.go('userInfo',{userInfoUserList:$scope.userList, userInfoUserWantList:$scope.userWantList});
  };   
})
}]);



wpApp.config( function( $stateProvider, $urlRouterProvider){
  // $urlRouterProvider.otherwise('/selection');
  $stateProvider
  .state( 'selection', {
      url: '/selection',
      controller: 'SelectionCtrl',
      templateUrl: appInfo.template_directory + 'templates/selection.html'
    })
    .state( 'userInfo', {
      url: '/userInfo',
      controller: 'InfoCtrl',
      templateUrl: appInfo.template_directory + 'templates/userInfo.html',
      params: {
            userInfoUserList: null,
            userInfoUserWantList: null,
        }
    })
     .state('home', {
        url: '/',
        templateUrl: appInfo.template_directory + 'templates/selection.html'
    })
      .state('submit', {
        url: '/submit',
        templateUrl: appInfo.template_directory + 'templates/process.php',
        params: {
            formData: null
        }
    })
});


wpApp.filter ( 'to_trusted', ['$sce', function( $sce ){
  return function( text ) {
    return $sce.trustAsHtml(text);
  }
}])