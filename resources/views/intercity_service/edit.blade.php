@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.intercity_service_plural')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a
                        href="{!! route('intercity-service') !!}">{{trans('lang.intercity_service_plural')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.intercity_service_edit')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card pb-4">
            <div class="card-header">
                <ul class="nav nav-tabs" id="language-tabs" role="tablist">
                </ul>
            </div>

            <div class="card-body">

                <div class="error_top"></div>

                <div class="row restaurant_payout_create">
                    <div class="restaurant_payout_create-inner">
                        <fieldset>
                            <legend>{{trans('lang.intercity_service_details')}}</legend>
                            <div class="tab-content" id="language-contents"></div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label global_value_label"></label>
                                <div class="col-7">
                                    <input type="number" class="form-control km_charge" min="0">
                                    <div class="form-text text-muted w-50 global_value_text">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="distanceType" />

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.image')}}</label>
                                <div class="col-7">
                                    <input type="file" onChange="handleFileSelect(event)" class="form-control image">
                                    <div class="placeholder_img_thumb intercity_service_image"></div>
                                    <div id="uploding_image"></div>
                                </div>
                            </div>

                            <div class="form-group row width-50 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="offer_rate" id="offer_rate">
                                    <label class="col-3 control-label"
                                        for="offer_rate">{{trans('lang.enable_offer_rate')}}</label>
                                </div>
                            </div>


                            <div class="form-group row width-50 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="intercity_service_active" id="active">
                                    <label class="col-3 control-label" for="active">{{trans('lang.enable')}}</label>
                                </div>

                            </div>
                            <div class="form-group row width-50 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="isGlobalAdminCommission" id="isGlobalAdminCommission">
                                    <label class="col-3 control-label"
                                        for="isGlobalAdminCommission">{{trans('lang.IsglobalAdminComossion')}}</label>
                                </div>
                            </div>
                            <div class="how_much_div">
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.commission_type')}}<span
                                            class="required-field"></span></label>
                                    <div class="col-7">
                                        <select class="form-control commission_type" id="commission_type">
                                            <option value="fix">{{trans('lang.fixed')}}</option>
                                            <option value="percentage">{{trans('lang.percentage')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.admin_commission')}}<span
                                            class="required-field"></span></label>
                                    <div class="col-7">
                                        <input type="number" class="form-control commission_fix">
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="form-group col-12 text-center btm-btn">
                    <button type="button" class="btn btn-primary  edit-form-btn"><i class="fa fa-save"></i> {{
                        trans('lang.save')}}
                    </button>
                    <a href="{!! route('intercity-service') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{
                        trans('lang.cancel')}}</a>
                </div>

            </div>

        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')

<script>
    var id="{{$id}}";
    var database=firebase.firestore();
    var ref=database.collection('intercity_service').where("id","==",id);
    var photo="";
    var append_list='';
    var placeholderImage="{{ asset('/images/default_user.png') }}";

    $(document).ready(function() {
        fetchLanguages().then(createLanguageTabs);

        $('.intercity_service_sub_menu li').each(function() {
            var url=$(this).find('a').attr('href');
            if(url==document.referrer) {
                $(this).find('a').addClass('active');
                $('.intercity_service_menu').addClass('active').attr('aria-expanded',true);
            }
            $('.intercity_service_sub_menu').addClass('in').attr('aria-expanded',true);
        });
        jQuery("#overlay").show();


        $('#isGlobalAdminCommission').click(function() {
            $('.how_much_div')[this.checked? "hide":"show"]();
        });
        ref.get().then(async function(snapshots) {
            var data=snapshots.docs[0].data();
            if(data&&Array.isArray(data.name)) {
                data.name.forEach(function(titleObj) {
                    var inputField=$(`#service-title-${titleObj.type}`);
                    if(inputField.length) {
                        inputField.val(titleObj.name);
                    }
                });
            }

            $(".km_charge").val(data.kmCharge);
            if(data.offerRate) {
                $('.offer_rate').prop('checked',true);
            }
            if(data.enable) {
                $('.intercity_service_active').prop('checked',true);
            }
            photo=data.image;
            if(photo!='') {

                $(".intercity_service_image").append('<img class="rounded" style="width:50px" src="'+photo+'" alt="image">');
            } else {

                $(".intercity_service_image").append('<img class="rounded" style="width:50px" src="'+placeholderImage+'" alt="image">');
            }
            console.log(data)
            if(data.hasOwnProperty('adminCommission')) {
                if(data.adminCommission.isEnabled) {
                    $("#isGlobalAdminCommission").prop('checked',true);
                    $(".how_much_div").hide();
                } else {
                    $("#isGlobalAdminCommission").prop('checked',false);
                    $(".how_much_div").show();
                }

                $(".commission_fix").val(data.adminCommission.amount);
                if(data.adminCommission.type) {
                    $("#commission_type").val(data.adminCommission.type);
                }
            }
            jQuery("#overlay").hide();
        });
    });

    $(".edit-form-btn").click(function() {

        var names=[];

        $("[id^='service-title-']").each(function() {
            var languageCode=$(this).attr('id').replace('service-title-','');

            var nameValue=$(this).val();

            names.push({
                name: nameValue,
                type: languageCode
            });
        });
        var isEnglishNameValid=names.some(function(nameObj) {
            return nameObj.type==='en'&&nameObj.name.trim()!=='';
        });

        var kmCharge=$(".km_charge").val();
        var enable=false;
        if($(".intercity_service_active").is(':checked')) {
            enable=true;
        }
        var offerRate=false;
        if($(".offer_rate").is(':checked')) {
            offerRate=true;
        }
        var isEnabled=$("#isGlobalAdminCommission").is(":checked")? true:false;
        if(isEnabled==false) {
            var commission_type=$("#commission_type :selected").val();
            var fix_commission=$(".commission_fix").val();
        } else {
            var commission_type='';
            var fix_commission='';
        }

        if(!isEnglishNameValid) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.intercity_service_name_error_en_required')}}</p>");
            window.scrollTo(0,0);
        } else if(kmCharge==''||kmCharge<=0) {
            $(".error_top").show();
            $(".error_top").html("");
            type=document.getElementById("distanceType").value;
            $(".error_top").append("<p>{{trans('lang.please_enter_valid')}} "+type+" {{trans('lang.charge')}}</p>");

            window.scrollTo(0,0);
        } else if(isEnabled==false&&fix_commission=='') {

            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.commission_help')}}</p>");
            window.scrollTo(0,0);


        } else {
            jQuery("#overlay").show();

            database.collection('intercity_service').doc(id).update({
                'name': names,
                'offerRate': offerRate,
                'kmCharge': kmCharge,
                'image': photo,
                'enable': enable,
                'adminCommission.isEnabled': isEnabled,
                'adminCommission.amount': fix_commission,
                'adminCommission.type': commission_type
            }).then(function(result) {
                jQuery("#overlay").hide();

                window.location.href='{{ route("intercity-service")}}';
            }).catch(function(error) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>"+error+"</p>");
            });
        }
    });

    var storageRef=firebase.storage().ref('intercityService');

    function handleFileSelect(evt) {
        $(".edit-form-btn").prop('disabled',true);
        var f=evt.target.files[0];
        var reader=new FileReader();

        reader.onload=(function(theFile) {
            return function(e) {

                var filePayload=e.target.result;
                var val=f.name;
                var ext=val.split('.')[1];
                var docName=val.split('fakepath')[1];
                var filename=(f.name).replace(/C:\\fakepath\\/i,'')

                var timestamp=Number(new Date());
                var filename=filename.split('.')[0]+"_"+timestamp+'.'+ext;
                var uploadTask=storageRef.child(filename).put(theFile);
                console.log(uploadTask);
                uploadTask.on('state_changed',function(snapshot) {

                    var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
                    console.log('Upload is '+progress+'% done');
                    jQuery("#uploding_image").text("Image is uploading...");

                },function(error) {},function() {
                    uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                        jQuery("#uploding_image").text("Upload is completed");
                        photo=downloadURL;
                        $(".intercity_service_image").empty();
                        $(".intercity_service_image").append('<img class="rounded" style="width:50px" src="'+photo+'" alt="image">');
                        $(".edit-form-btn").prop('disabled',false);
                    });
                });

            };
        })(f);
        reader.readAsDataURL(f);
    }
    async function fetchLanguages() {
        const languagesRef=database.collection('languages').where('isDeleted','==',false);
        const snapshot=await languagesRef.get();
        const languages=[];
        snapshot.forEach(doc => {
            languages.push(doc.data());
        });
        return languages;
    }

    function createLanguageTabs(languages) {
        const tabsContainer=document.getElementById('language-tabs');
        const contentsContainer=document.getElementById('language-contents');

        tabsContainer.innerHTML='';
        contentsContainer.innerHTML='';

        const defaultLanguage=languages.find(language => language.isDefault);
        const otherLanguages=languages.filter(language => !language.isDefault);
        otherLanguages.sort((a,b) => a.name.localeCompare(b.name));
        const sortedLanguages=[defaultLanguage,...otherLanguages];
        sortedLanguages.forEach((language,index) => {
            var defaultClass='';
            if(language.isDefault) {
                defaultClass='{{trans("lang.default")}}';
            }
            const tab=document.createElement('li');
            tab.classList.add('nav-item');
            tab.innerHTML=`
            <a class="nav-link ${index===0? 'active':''}" id="tab-${language.code}" data-bs-toggle="tab" href="#content-${language.code}" role="tab" aria-selected="${index===0}">
                ${language.name} (${language.code.toUpperCase()})
                <span class="badge badge-success ml-2">${defaultClass}</span>

            </a>
        `;
            tabsContainer.appendChild(tab);

            const content=document.createElement('div');
            content.classList.add('tab-pane','fade');
            if(index===0) {
                content.classList.add('show','active');
            }
            content.id=`content-${language.code}`;
            content.role="tabpanel";
            content.innerHTML=`
           <div class="form-group row width-100">
                <label class="col-3 control-label" for="zone-${language.code}">{{trans('lang.intercity_service_name')}} (${language.code.toUpperCase()})<span class="required-field"></span></label>
                <div class="col-7">
                    <input type="text" class="form-control" id="service-title-${language.code}">
                    <div class="form-text text-muted">{{ trans("lang.intercity_service_name_help") }}</div>
                </div>                             
            </div>
        `;
            contentsContainer.appendChild(content);
        });

        const triggerTabList=document.querySelectorAll('#language-tabs a');
        triggerTabList.forEach(tab => {
            tab.addEventListener('click',function(event) {
                event.preventDefault();

                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('active','show');
                });

                document.querySelectorAll('.nav-link').forEach(function(navTab) {
                    navTab.classList.remove('active');
                });

                this.classList.add('active');
                const target=this.getAttribute('href');
                const targetPane=document.querySelector(target);
                if(targetPane) {
                    targetPane.classList.add('active','show');
                }
            });
        });
    }

</script>
@endsection