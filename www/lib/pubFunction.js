(function(a,f,j){var x={form:document.getElementById("trainingsform")||"",folderSelect:document.getElementById("themeRow")||"",leftContainer:document.getElementById("mySlideshowsContainer")||"",rightContainer:document.getElementById("myGroupsContainer")||"",iframe:document.getElementById("previewIframe")||"",diskAreaId:document.getElementsByName("diskArea_id").value,saveAllButton:document.getElementById("saveAll")||""},u={slideshowList:document.getElementById("slideShowList")||"",folderSelector:document.getElementById("daForSlideShow")||""},F={attachList:document.getElementById("editorsMediaBox")||"",mediaList:document.getElementById("myMediaList")||"",groupList:document.getElementById("mediaBoxList")||"",sortingBar:document.getElementById("sortingIconBar")||""},s={trainingList:document.getElementById("trainingList")||"",folderSelector:document.getElementById("daForTrainings")||""},g={trainingStatusSelector:document.getElementById("trainingStatusSelector")||"",trainingStatus:document.getElementById("trainingStatus")||""},E={groupList:document.getElementById("GroupList")||"",row:[]},t={slideshowList:document.getElementById("myTrainingsList")||"",statusChanger:document.getElementById("trainingStatus")||"",uploadInput:document.getElementById("upload")||"",fileupload:document.getElementById("fileupload")||"",uploadCoverButton:document.getElementById("uploadCover")||"",clearCoverButton:document.getElementById("clearCover")||"",coverImage:document.getElementById("coverImg")||"",form:document.getElementById("detailsform")||"",detailsElements:{cover:document.getElementById("coverImg")||"",title:document.getElementById("name")||"",authors:document.getElementById("authors")||"",description:document.getElementById("description")||"",insertCode:document.getElementById("insertCode")||"",createNewButton:document.getElementById("createNewTrainng")||"",deleteTrainingButton:document.getElementById("deleteTraining")||""},insertCodeArray:['<div class="iframeBorderDiv" style="width:870px;height:489px;border:0;overflow:hidden;"><iframe src="','" width="100%" height="100%" style="border:0;" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen="" oallowfullscreen="" msallowfullscreen=""></iframe></div>'],slideshowsElements:{previewButton:document.getElementById("previewTraining")||"",exitPreviewButton:document.getElementById("exitPreview")||"",removeButton:document.querySelectorAll("span.removeSlideshow.btn-dark")||"",typeChangeButton:document.querySelectorAll(".typeChanger")||"",previewSlideshowList:{listholder:document.getElementsByClassName("previewSlideshowList")||"",init:function(){t.slideshowsElements.previewSlideshowList.createlinks();t.slideshowsElements.previewSlideshowList.gatherlinks()},destroy:function(){f(t.slideshowsElements.previewSlideshowList.listholder).html("")},createlinks:function(){t.slideshowsElements.previewSlideshowList.destroy();f(t.slideshowList).find("li.userElement").each(function(){var H=f(this).attr("data-id"),G=f(this).find("span.name").text();f(t.slideshowsElements.previewSlideshowList.listholder).append('<li><a href="#" data-sid="'+H+'">'+G+"</a></li>")})},gatherlinks:function(){f(t.slideshowsElements.previewSlideshowList.listholder).find("li > a").each(function(){addEventO(this,"click",function(H){H.preventDefault();var G=f(this).attr("data-sid");B.previewTraining(B.selectedId,G)},true,_eventHandlers)})}},init:function(){t.slideshowsElements.removeButton=document.querySelectorAll("span.removeSlideshow.btn-dark");B.deleteSlideshows(t.slideshowsElements.removeButton);t.slideshowsElements.typeChangeButton=document.querySelectorAll(".typeChanger");B.changeSlideshowType(t.slideshowsElements.typeChangeButton)}},instanceElements:{instanceList:document.getElementById("myInstances")||"",newInstanceButton:document.getElementById("addNewInstance")||"",removeButton:document.querySelectorAll("span.removeInstance.btn-dark")||"",droppedusers:document.querySelectorAll("span.droppedusers.badge")||"",init:function(){t.instanceElements.removeButton=document.querySelectorAll("span.removeInstance.btn-dark");y.deleteInstance(t.instanceElements.removeButton);t.instanceElements.droppedusers=document.querySelectorAll("span.droppedusers.badge")}}},k=[],w="",h="",v={},q=0,d=null,A=null,b={},z={url:"",data:b,responseType:"json"},m={slideshows:{0:"load",1:"delete"},trainings:{0:"load",1:"delete",2:"update",3:"new",4:"list",5:"toArray",6:"updateStatus",7:"deletemaster"},groups:{0:"load"},instances:{0:"load",1:"delete",2:"new",3:"changeData"},mediafiles:{0:"load",1:"loadgroup",2:"updatefiles"}},r={0:x.leftContainer,1:x.rightContainer};var l="data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";var D=160;var c=224;var C={init:function(){B.addDND()},viewSlideshows:function(){b={};b.action=m.slideshows[0];b.form=f(x.form).serializeArray();b.folderId=f(u.folderSelector).attr("data-diskarea-id");z.url="/crawl?/process/publication/handelslideshow/";z.data=b;var G=getJsonData(z);if(!G.result){return false}f(u.slideshowList).html(tmpl("tmpl-miniSlides",G));B.addDND()},setSelected:function(G){}};var p={init:function(){this.filterFiles();this.selectFiles()},selectFiles:function(){f(F.groupList).find("li:not(.selected) a.level2").live("click",function(G){var I=f(this);G.preventDefault();G.stopPropagation();I.parent().siblings().removeClass("selected");I.parent().addClass("selected");var H=f(this).find("span.name").text();H=H.length>9?H.substring(0,8)+"...":H;f(F.groupList).prev().find("span.name").text(H).attr("title",f(this).find("span.name").text());p.viewFiles(I.attr("data-id"));f(".selectMenu").parent().removeClass("open")})},removeFiles:function(G){f("#confirmDiv").confirmModal({heading:"Alert",body:"Delete selected attachment?",text:"Delete",cancel:true,type:"question",callback:function(){G.remove()}})},saveFiles:function(){var G=[];f(F.mediaList).find("li.mediaElement").each(function(H,I){G.push(f(I).attr("data-id"))});return G},viewFiles:function(H){b={};b.action=H=="all"?m.mediafiles[0]:m.mediafiles[1];b.groupid=H;b.form=f(x.form).serializeArray();b.diskArea=x.diskAreaId;z.url="/crawl?/process/publication/loadmediafiles/";z.data=b;var G=getJsonData(z);if(!G){return false}f(F.attachList).html(tmpl("tmpl-mediaElement",G));this.addDND()},filterFiles:function(){f(F.sortingBar).find("button").bind("click",function(){if(f(F.attachList).find("li").length==0){return false}var H=f(this).attr("data-class");f(F.attachList).find("li").hide();var G=H.split(/\s+/g);for(i in G){H==""?f(F.attachList).find("li").show():f(F.attachList).find("li."+G[i]).show()}})},setAction:function(){f(F.mediaList).find(".deleteButton").live("click",function(){var G=f(this).closest("li.mediaElement");p.removeFiles(G)})},addDND:function(){f(F.attachList).find("li.mediaElement").draggable(this.myMediaDragOption);f(F.mediaList).sortable(p.sortableAttach)},myMediaDragOption:{appendTo:"body",handle:"img",revert:"true",helper:"clone",start:function(H,G){f(F.mediaList).droppable(p.attachDropOption)},stop:function(H,G){f(F.mediaList).droppable("destroy").sortable(p.sortableAttach);p.setAction()}},attachDropOption:{tolerance:"touch",activeClass:"ui-state-highlight",hoverClass:"ui-state-active",greedy:true,drop:function(I,H){var G=H.draggable.clone();f(this).append(G);f(F.mediaList).sortable(p.sortableAttach)}},sortableAttach:{receive:function(G,H){},stop:function(H,G){}}};var B={selectedId:"",isSlideshowSaved:false,init:function(){t.slideshowsElements.previewSlideshowList.destroy();this.setTrainingActions();addEventO(t.uploadInput,"change",function(G){n(G,t.coverImage)},false,_eventHandlers);addEventO(t.uploadCoverButton,"click",function(){f(t.uploadInput).trigger("click");return false},true,_eventHandlers);addEventO(t.clearCoverButton,"click",function(){t.coverImage.src=l;f(t.form).find('input[name="cover"]').val("")},true,_eventHandlers);addEventO(t.detailsElements.createNewButton,"click",function(G){G.preventDefault();B.newTraining()},true,_eventHandlers);addEventO(t.detailsElements.deleteTrainingButton,"click",function(G){G.preventDefault();B.deleteTraining(B.selectedId)},true,_eventHandlers);addEventO(x.saveAllButton,"click",function(G){G.preventDefault();B.saveTraining(B.selectedId)},true,_eventHandlers);addEventO(t.slideshowsElements.exitPreviewButton,"click",function(G){G.preventDefault();B.closePreview()},true,_eventHandlers);f(g.trainingStatus).find("a").bind("click",function(G){G.stopPropagation();if(B.selectedId==""){return false}B.setStatus(B.selectedId,f(this))});addEventO(t.instanceElements.newInstanceButton,"click",function(G){G.preventDefault();if(B.selectedId==""){return false}y.newInstance()},true,_eventHandlers)},upload:function(){n(t.upload,t.cover);f(t.form).find('input[name="cover"]').val(t.detailsElements.cover.src)},setStatus:function(H,J){if(f(t.slideshowList).find("li.userElement").length==0){sendMessage("alert-error","No slideshows in training.");return false}if(J.attr("data-status")=="ready"){f("#confirmDiv").confirmModal({heading:"Remember",body:"After setting training status 'go Public', you can't edit slideshow in slideeditor until you set status back to 'Draft'!",text:"OK",type:"question",callback:function(){return false}})}b={};b.action=m.trainings[6];b.form=f(x.form).serializeArray();b.status=J.attr("data-status");z.url="/crawl?/process/publication/handeltraining/";z.data=b;var I=getJsonData(z);if(!I){return false}J.parent().siblings("li").removeClass("selected").end();J.parent().addClass("selected");f(g.trainingStatusSelector).find("span.name").text(J.find("span.name").text());f(g.trainingStatusSelector).find("span.label").attr("class",J.find("span.label").attr("class"));f(g.trainingStatusSelector).parent().removeClass("open");var G=f(s.trainingList).find(".dataHolder.selected");G.find(".colorTr").attr("class","colorTr "+J.attr("data-status"))},viewTrainings:function(){b={};b.action=m.trainings[4];b.form=f(x.form).serializeArray();b.folderId=f(s.folderSelector).attr("data-diskarea-id");z.url="/crawl?/process/publication/handeltraining/";z.data=b;var G=getJsonData(z);if(!G.result){return false}f(s.trainingList).html(tmpl("tmpl-miniTrainings",G));this.setTrainingActions()},setTrainingActions:function(){this.gatherTrainings();B.addDND()},loadTraining:function(I){b={};b.action=m.trainings[0];b.form=f(x.form).serializeArray();b.trainingId=I.id;z.url="/crawl?/process/publication/handeltraining/";z.data=b;var K=getJsonData(z);if(!K.main){return false}var J=K.main[0];this.selectedId=J.id;f(x.form).find('input[name="id"]').val(J.id);t.detailsElements.cover.src=J.cover;f(t.form).find('input[name="cover"]').val(J.cover);t.detailsElements.title.value=J.name;A.setValue(J.description,true);if(K.result){t.slideshowList.innerHTML="";f(t.slideshowList).append(tmpl("tmpl-loadtraining",K));f(u.slideshowList).find("li").removeClass("disabled");f(t.slideshowList).find("li").each(function(){var M=f(this).attr("data-id");f(u.slideshowList).find('li[id="'+M+'"]').addClass("disabled").end()});var G=f(t.slideshowList).find("li:eq(0)").attr("data-id");var L=new Date().getTime();t.detailsElements.insertCode.value=t.insertCodeArray[0]+h+J.id+"/"+G+"/?tokenId="+L+t.insertCodeArray[1];f(g.trainingStatus).find("li").removeClass("selected");f(g.trainingStatus).find('a[data-status="'+J.activeState+'"]').parent().addClass("selected");f(g.trainingStatusSelector).find("span.label").attr("class","label label-"+J.activeState);f(g.trainingStatusSelector).find("span.name").text(f("#trainingStatus li.selected").find("span.name").text());f(s.trainingList).find("li > .dataHolder").removeClass("selected").end();f(s.trainingList).find('li[id="'+J.id+'"] > .dataHolder').addClass("selected");if(K.attach){var H=[];H.result=K.attach;f(F.mediaList).html(tmpl("tmpl-mediaElement",H));p.addDND();p.setAction()}else{f(F.mediaList).html("")}B.addDND();t.slideshowsElements.init();t.slideshowsElements.previewSlideshowList.init();y.init();B.isSlideshowSaved=!!(f(t.slideshowList).find("li.userElement").length>0)}},saveTraining:function(N){if(N==""&&f(t.detailsElements.title).val().replace(/\s/g,"").length==0){sendMessage("alert-warning","Please give a title!");return false}var I=f(x.form).find('input[name="id"]').val();if(f(t.slideshowList).find("li:eq(0)").length&&I){var K=f(t.slideshowList).find("li:eq(0)").attr("data-id");var O=new Date().getTime();t.detailsElements.insertCode.value=t.insertCodeArray[0]+h+I+"/"+K+"/?tokenId="+O+t.insertCodeArray[1]}else{t.detailsElements.insertCode.value=""}b={};b.action=m.trainings[2];b.form=f(x.form).serializeArray();b.details=f(t.form).serializeArray();var M=f(t.slideshowList).nestedSortable("toArray",{nestedType:"training",startDepthCount:0,attribute:"data-id",slideShowId:f('#trainingsform [name="id"]').val()});var H=[];f(t.slideshowList).find("li.userElement").each(function(){var Q=[];var S=f(this).attr("data-id");var R=f(this).find(".typeChanger:first");var P=R.closest("form");Q=P.serializeArray();Q.push({name:"id",value:S});H.push(Q)});b.toArray=M;b.test=toObject(H);b.attachment=p.saveFiles();z.url="/crawl?/process/publication/handeltraining/";z.data=b;var G=getJsonData(z);if(!G.result[0].id){return false}this.selectedId=G.result[0].id;switch(G.result[0].status){case"new":f(s.trainingList).prepend(tmpl("tmpl-miniTrainings",G));f(s.trainingList).find(".dataHolder").removeClass("selected").end();f(s.trainingList).find('li[id="'+B.selectedId+'"] > .dataHolder').addClass("selected");f(x.form).find('input[name="id"]').val(B.selectedId);break;case"update":var J=tmpl("tmpl-miniTrainings",G);var L=f(J).find(".dataHolder").html();f(s.trainingList).find('li[id="'+B.selectedId+'"] > .dataHolder').html(L);break}},deleteTraining:function(H){if(H==""){return false}var G="Do you want to delete master training and all instances?";f("#confirmDiv").confirmModal({heading:"Question",body:G,text:"Delete training",type:"question",cancel:true,callback:function(){b={};b.action=m.trainings[7];b.form=f(x.form).serializeArray();z.url="/crawl?/process/publication/handeltraining/";z.data=b;var I=getJsonData(z);if(!I){return false}B.newTraining();f(s.trainingList).find('li[id="'+H+'"]').remove();f(u.slideshowList).find("li").removeClass("disabled");t.coverImage.src=l;f(t.form).find('input[name="cover"]').val("");t.slideshowsElements.previewSlideshowList.destroy();return false}})},newTraining:function(){f(x.form).find('input[name="id"]').val("");f(g.trainingStatus).find("li").removeClass("selected");f(g.trainingStatus).find('a[data-status="draft"]').parent().addClass("selected");f(g.trainingStatusSelector).find("span.label").attr("class","label label-draft");f(g.trainingStatusSelector).find("span.name").text(f("#trainingStatus li.selected").find("span.name").text());f(s.trainingList).find("li > .dataHolder").removeClass("selected").end();f(t.form).find(":input").each(function(){switch(this.type){case"select-one":case"text":case"textarea":f(this).val("");break;case"checkbox":case"radio":this.checked=false}});f(t.detailsElements.description).data("wysihtml5").editor.clear();f(t.detailsElements.insertCode).val("");f(u.slideshowList).find("li").removeClass("disabled");f(t.slideshowList).empty();f(t.instanceElements.instanceList).empty();this.selectedId="";this.isSlideshowSaved=false;t.coverImage.src=l;f(t.form).find('input[name="cover"]').val("");t.slideshowsElements.previewSlideshowList.destroy();f(F.mediaList).empty();this.addDND()},saveSlideshows:function(I){if(I==""){return false}b={};var H=f(t.slideshowList).nestedSortable("toArray",{nestedType:"training",startDepthCount:0,attribute:"data-id",slideShowId:f('#trainingsform [name="id"]').val()});var G=[];f(t.slideshowList).find("li.userElement").each(function(){var L=[];var N=f(this).attr("data-id");var M=f(this).find(".typeChanger:first");var K=M.closest("form");L=K.serializeArray();L.push({name:"id",value:N});G.push(L)});b.toArray=H;b.action=m.trainings[5];b.form=f(x.form).serializeArray();b.test=toObject(G);z.url="/crawl?/process/publication/handeltraining/";z.data=b;var J=getJsonData(z);if(!J){return false}B.isSlideshowSaved=true;t.slideshowsElements.previewSlideshowList.init()},deleteSlideshows:function(G){f(G).each(function(H,I){addEventO(I,"click",function(){var N=f(I).closest("li.userElement");var O=N.attr("data-id");var L=N.find("li.userElement");var K=L.length;var M=f(t.slideshowList).html();var J="";J=K>0?K+" more slideshow is connected to the selected":"Do you really want to delete this slideshow?";f("#confirmDiv").confirmModal({heading:"Question",body:J,text:"Delete slidehow"+(K>0?"'s":""),type:"question",cancel:true,callback:function(){N.remove();var P=f(t.slideshowList).nestedSortable("toArray",{nestedType:"training",startDepthCount:0,attribute:"data-id",slideShowId:f('#trainingsform [name="id"]').val()});b={};b.toArray=P;b.action=m.trainings[1];b.form=f(x.form).serializeArray();b.sid=O;z.url="/crawl?/process/publication/handeltraining/";z.data=b;var Q=getJsonData(z);if(!Q){f(t.slideshowList).html(M);return false}M="";f(u.slideshowList).find('li[id="'+O+'"]').removeClass("disabled");t.slideshowsElements.init();t.slideshowsElements.previewSlideshowList.init();B.isSlideshowSaved=!!(f(t.slideshowList).find("li.userElement").length>0);return false}})},true,_eventHandlers)})},changeSlideshowType:function(G){f(G).each(function(H,I){addEventO(I,"click",function(){var L=f(I).closest("li.userElement");var M=L.attr("data-id");var K=f(I).closest("form");var J=K.find(".optionRow");if(f(I).is(":checked")){J.removeClass("hidden");f(I).val("1").attr("checked",true);f("#confirmDiv").confirmModal({heading:"Remember",body:"In TEST version stepping back between slides are ignored! Only straight forward is allowed!",text:"OK",type:"question",callback:function(){return false}})}else{J.addClass("hidden");f(I).val("0").attr("checked",false)}},true,_eventHandlers)})},gatherTrainings:function(){f(s.trainingList).find("li.publicationElement").live("click",function(G){G.preventDefault();B.loadTraining(this)})},addDND:function(){f(t.slideshowList).nestedSortable(B.sortableTrainings).droppable(B.dropOnList);f("li.slideshowslide").draggable(B.dragSlideshows)},previewTraining:function(G,H){if(this.selectedId==""){sendMessage("alert-warning","No training selected!");return false}if(B.isSlideshowSaved){x.iframe.src=w+this.selectedId+"/"+H+"/";f(x.iframe)[0].contentWindow.focus()}else{sendMessage("alert-warning","Save modifications before preview!");return false}f("div.row.special").slideUp("fast");f("div.preview").removeClass("hidden");f("html, body").animate({scrollTop:f(document).height()},1000)},closePreview:function(){var G=f(this).attr("data-type");f("div.row.special").slideDown("slow");f("div.preview").addClass("hidden");x.iframe.src=""},sortableTrainings:{handle:".span3 > .name",items:"li",toleranceElement:"> .trainingdata",placeholder:"placeholder",forcePlaceholderSize:true,isTree:true,maxLevels:3,tabSize:25,update:function(H,G){f(t.slideshowList).find("li.userElement").each(function(J,K){var I=f(K).parents("li").length;f(K).find(".badge.level").text(I+1);f(K).find(".colorBar").css("border-left-width",(I+1)*2+"px")});B.isSlideshowSaved=false},stop:function(H,G){if(G.position.left<-2000){var I=G.item[0].attributes["data-id"].value;f(t.slideshowList).find('li[data-id="'+I+'"]').remove()}B.isSlideshowSaved=false}},dropOnList:{tolerance:"pointer",accept:"#slideShowList li:not(.disabled)",activeClass:"ui-state-highlight",hoverClass:"ui-state-highlight",greedy:true,drop:function(I,H){var G=f("#draggingContainer3").find("li"),J=G.attr("data-id");f(this).append(G);G.css("z-index","1");f(this).css("height",(f(this).find("li").length+1)*45+"px");f(u.slideshowList).find('li[id="'+J+'"]').addClass("disabled").end();t.slideshowsElements.init();B.isSlideshowSaved=false}},dragSlideshows:{appendTo:"body",handle:".rightSide",revert:true,opacity:0.7,dropOnEmpty:true,helper:function(K,M){var J=f(K.target).closest("li.slideElement"),H,I={position:"",left:"",top:"","z-index":"10000"};if(f("#draggingContainer3").length==0){H=f("<ul/>").appendTo("body").attr("id","draggingContainer3")}else{H=f("#draggingContainer3");H.empty()}var L={};L.result=[];L.result.push({name:J.attr("data-name"),id:J.attr("id"),type:0,repetable:0,credit:"",testtype:1});var G=tmpl("tmpl-trainingslides",L);H.addClass("span8").append(G).css(I);f("li",H).css(I);return H},start:function(G,H){f("#draggingContainer3").css({position:"absolute"})}}};var y={init:function(){this.viewInstances()},viewInstances:function(){b={};b.action=m.instances[0],b.form=f(x.form).serializeArray();z.url="/crawl?/process/publication/handelinstances/";z.data=b;var G=getJsonData(z);if(!G.result){return false}f(t.instanceElements.instanceList).html(tmpl("tmpl-traininginstances",G));t.instanceElements.init();this.addDND();e()},deleteInstance:function(G){if(G==""){return false}f(G).each(function(H,I){addEventO(I,"click",function(){var K=f(I).closest("li.userElement");var L=K.attr("data-id");var J="Do you want to delete this instance?";f("#confirmDiv").confirmModal({heading:"Question",body:J,text:"Delete instance",type:"question",cancel:true,callback:function(){b={};b.action=m.instances[1];b.form=f(x.form).serializeArray();b.id=L;z.url="/crawl?/process/publication/handelinstances/";z.data=b;var M=getJsonData(z);if(!M){return false}K.remove();t.instanceElements.init();return false}})},true,_eventHandlers)})},newInstance:function(){b={};b.action=m.instances[2];b.form=f(x.form).serializeArray();z.url="/crawl?/process/publication/handelinstances/";z.data=b;var G=getJsonData(z);if(!G.result){return false}f(t.instanceElements.instanceList).append(tmpl("tmpl-traininginstances",G));t.instanceElements.init();this.addDND();e()},dropBox:function(){f(".droppedusers").live("click",function(I){I.stopPropagation();I.preventDefault();var H=f(this).attr("data-traininggroup");if(typeof H!=="undefined"&&H.length>0){var G=H.split(",");f.each(G,function(J,K){f(E.groupList).find('li[data-object-id="'+G[J]+'"]').addClass("greenBg")});setTimeout(function(){f(E.groupList).find("li").removeClass("greenBg")},2500)}})},addDND:function(){f(t.instanceElements.droppedusers).droppable(this.dropOnGroup).draggable(this.emptyGroup);this.dropBox()},dropOnGroup:{tolerance:"pointer",accept:"#GroupList li:not(.disabled)",hoverClass:"ui-state-highlight",greedy:true,drop:function(L,N){var J=f("#draggingContainer2").find("li").attr("data-object-id");var H=f(this).attr("data-groupcount");var G=f(this).attr("data-traininggroup");var I=f(this).text();if(G.length>0&&G.indexOf(J)!==-1){sendMessage("alert-warning","This group is already added to this instance");return false}var M=G.length>0?G.split(","):[];M.push(J);var O=M.length;f(this).attr("data-groupcount",M.length);f(this).text(M.length+" group");f(this).attr("data-traininggroup",M.join(","));f("#draggingContainer2").animate({width:["toggle","swing"],height:["toggle","swing"],opacity:"toggle"},700,"linear",function(){f(this).empty()});b={};b.action=m.instances[3];b.form=f(x.form).serializeArray();b.pk=f(this).closest("li.userElement").attr("data-id");b.name="traininggroups";b.value=f(this).attr("data-traininggroup");z.url="/crawl?/process/publication/handelinstances/";z.data=b;var K=getJsonData(z);if(!K){f(this).attr("data-groupcount",H);f(this).text(I);f(this).attr("data-traininggroup",G)}return false}},emptyGroup:{appendTo:"body",handle:"span",revert:true,opacity:0.7,dropOnEmpty:true,helper:"clone",stop:function(H,I){var J=f(this);var G="Reset training group list?";f("#confirmDiv").confirmModal({heading:"Question",body:G,text:"Reset training groups",type:"question",cancel:true,callback:function(){var K=J.attr("data-groupcount");var N=J.attr("data-traininggroup");var M=J.text();J.text("Drop group here").attr("data-traininggroup","").attr("data-groupcount","");b={};b.action=m.instances[3];b.form=f(x.form).serializeArray();b.pk=J.closest("li.userElement").attr("data-id");b.name="traininggroups";b.value="";z.url="/crawl?/process/publication/handelinstances/";z.data=b;var L=getJsonData(z);if(!L){J.attr("data-groupcount",K);J.text(M);J.attr("data-traininggroup",N);return false}t.instanceElements.init();return false}})}}};var o={init:function(){this.gatherGroups()},viewGroups:function(){b={};b.action=m.groups[0],b.form=f(x.form).serializeArray();z.url="/crawl?/process/publication/handeltraininggroups/";z.data=b;var G=getJsonData(z);if(!G.result){return false}f(E.groupList).html(tmpl("tmpl-trainingGroupList",G));this.gatherGroups()},gatherGroups:function(){E.row=[];f(E.groupList).find("li.mbcholder").each(function(){E.row.push({"data-object-id":f(this).attr("data-object-id"),"data-object-name":f(this).attr("data-object-name")})});f(E.groupList).find("li.mbcholder").live("click",function(){o.addDND()});this.addDND()},addDND:function(){f(E.groupList).find("li.mediaBox").draggable(o.dragUser)},dragUser:{appendTo:"body",handle:".name",revert:true,opacity:0.7,helper:function(J,K){var I=f(this),G,H={position:"",left:"",top:"","z-index":"10000"};if(f("#draggingContainer2").length==0){G=f("<ul/>").appendTo("body").attr("id","draggingContainer2")}else{G=f("#draggingContainer2");G.empty()}G.addClass("span2").append(I.clone().addClass("selected")).css(H);f("li",G).css(H);return G},start:function(G,H){f("#draggingContainer2").css({position:"absolute"})}}};a.init=function(H,G,I){f("#loading").show();f.fn.editable.defaults.mode="inline";f.fn.editable.defaults.dataType="json";f.fn.editable.defaults.emptytext="Please, fill this";f.fn.editable.defaults.url="/crawl?/process/publication/handeltraining/";f.fn.editable.defaults.params=function(J){J.action="changeData";return J};w=H;h=G;x.diskAreaId=I;d=f(t.detailsElements.description).wysihtml5({html:false,link:false,image:false,color:false});A=d.data("wysihtml5").editor;f(u.slideshowList).slimScroll({position:"left",height:"300px",allowPageScroll:false,width:"190px"});f(s.trainingList).slimScroll({position:"left",height:"300px",allowPageScroll:false,width:"190px"});f(E.groupList).slimScroll({position:"right",height:"300px",allowPageScroll:false,width:"170px"});f(F.attachList).slimScroll({position:"left",height:"300px",allowPageScroll:false,width:"170px"});initAffix(r);initAccordion();B.init();C.init();o.init();p.init();f("#loading").hide()};this.initAccordion=function(){f(".accordion").on("show",function(G){f(G.target).prev(".accordion-heading").find(".accordion-toggle").addClass("active");f(G.target).prev(".accordion-heading").find(".accordion-toggle i").removeClass("icon-plus");f(G.target).prev(".accordion-heading").find(".accordion-toggle i").addClass("icon-minus")});f(".accordion").on("hide",function(G){f(this).find(".accordion-toggle").not(f(G.target)).removeClass("active");f(this).find(".accordion-toggle i").not(f(G.target)).removeClass("icon-minus");f(this).find(".accordion-toggle i").not(f(G.target)).addClass("icon-plus")});f(".accordion-toggle:not(.active)").find("i").addClass("icon-plus");f(".accordion-toggle.active").find("i").addClass("icon-minus")};function e(){f(".date").datepicker().on("changeDate",function(G){b={};b.action=m.instances[3];b.form=f(x.form).serializeArray();b.name=f(this).find("input").attr("name");b.value=f(this).find("input").val();b.pk=f(this).closest("li.userElement").attr("data-id");z.url="/crawl?/process/publication/handelinstances/";z.data=b;var H=getJsonData(z);f(this).datepicker("hide")});f(".timepicker").timepicker({showSeconds:false,showMeridian:false}).on("hide.timepicker",function(H){b={};b.action=m.instances[3];b.form=f(x.form).serializeArray();b.name=f(H.target).attr("name");b.value=H.time.value;b.pk=f(H.target).closest("li.userElement").attr("data-id");z.url="/crawl?/process/publication/handelinstances/";z.data=b;var G=getJsonData(z)})}function n(H,J){var I=H.target.files[0];var G=new FileReader();G.onloadend=function(){var K=new Image();K.src=G.result;K.onload=function(){var L=resizeCrop(this,D,c,-2).toDataURL("image/jpg",90);f(J).attr("src",L);f(t.form).find('input[name="cover"]').val(f(J).attr("src"))}};G.readAsDataURL(I)}}(window.Publication=window.Publication||{},jQuery));