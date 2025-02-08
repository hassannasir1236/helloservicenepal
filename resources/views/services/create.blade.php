@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{ trans('lang.service_plural') }}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('services') !!}">{{ trans('lang.service_plural') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ trans('lang.service_create') }}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs" id="language-tabs" role="tablist">
                </ul>
            </div>
            <div class="card-body">

                <div class="error_top"></div>

                <div class="row restaurant_payout_create">
                    <div class="restaurant_payout_create-inner">
                        <fieldset>
                            <legend>{{ trans('lang.service_details') }}</legend>
                            <div class="tab-content" id="language-contents">
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label global_value_label"></label>
                                <div class="col-7">
                                    <input type="number" class="form-control km_charge" min="0">
                                    <div class="form-text text-muted w-50 global_value_text">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="distanceType" />

                            <div class="form-group row width-100">
                                <label class="col-3 control-label">{{ trans('lang.image') }}</label>
                                <div class="col-7">
                                    <input type="file" onChange="handleFileSelect(event)" class="form-control image"
                                        id="service_image">
                                    <div class="placeholder_img_thumb service_image"></div>
                                    <div id="uploding_image"></div>
                                </div>
                            </div>




                            <div class="form-group row width-50">
                                <div class="form-check">
                                    <input type="checkbox" class="service_active" id="active">
                                    <label class="col-3 control-label" for="active">{{ trans('lang.enable') }}</label>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <div class="form-check">
                                    <input type="checkbox" class="intercity_type" id="intercityType">
                                    <label class="col-3 control-label" for="intercityType">{{
    trans('lang.service_intercity') }}</label>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <div class="form-check">
                                    <input type="checkbox" class="offer_rate" id="offer_rate">
                                    <label class="col-3 control-label" for="offer_rate">{{
    trans('lang.enable_offer_rate') }}</label>
                                </div>
                            </div>
                            <div class="form-group row width-50">
                                <div class="form-check">
                                    <input type="checkbox" class="IsglobalAdminComission" id="IsglobalAdminComission"
                                        onclick="ShowHideDiv()">
                                    <label class="col-3 control-label" for="IsglobalAdminComission">{{
    trans('lang.IsglobalAdminComossion') }}</label>
                                </div>
                            </div>
                            <div class="form-group row width-50" id="comissionType">
                                <label class="col-4 control-label">{{ trans('lang.commission_type') }}</label>
                                <div class="col-7">
                                    <select class="form-control commission_type" id="commission_type">
                                        <option value="fix">{{ trans('lang.fixed') }}</option>
                                        <option value="percentage">{{ trans('lang.percentage') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row width-50" id="comission">
                                <label class="col-4 control-label">{{ trans('lang.admin_commission') }}<span
                                        class="required-field"></span></label>
                                <div class="col-7">
                                    <input type="number" class="form-control commission">
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="form-group col-12 text-center btm-btn">
                    <button type="button" class="btn btn-primary  save-form-btn"><i class="fa fa-save"></i>
                        {{ trans('lang.save') }}
                    </button>
                    <a href="{!! route('services') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{
    trans('lang.cancel') }}</a>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var database=firebase.firestore();
    var photo="";

    function ShowHideDiv() {
        let enableCommision=$("#IsglobalAdminComission").is(":checked");
        if(enableCommision) {
            $("#comissionType").hide();
            $("#comission").hide();
        } else {
            $("#comissionType").show();
            $("#comission").show();
        }
    }

    $(document).ready(function() {
        fetchLanguages().then(createLanguageTabs);

        $('.ride_sub_menu li').each(function() {
            var url=$(this).find('a').attr('href');
            if(url==document.referrer) {
                $(this).find('a').addClass('active');
                $('.rides_menu').addClass('active').attr('aria-expanded',true);
            }
            $('.ride_sub_menu').addClass('in').attr('aria-expanded',true);
        });
    });

    $(".save-form-btn").click(function() {
        var titles=[];

        $("[id^='service-title-']").each(function() {
            var languageCode=$(this).attr('id').replace('service-title-','');
            var nameValue=$(this).val();

            titles.push({
                title: nameValue,
                type: languageCode
            });
        });
        var isEnglishNameValid=titles.some(function(nameObj) {
            return nameObj.type==='en'&&nameObj.title.trim()!=='';
        });

        var kmCharge=$(".km_charge").val();

        var enable=false;
        if($(".service_active").is(':checked')) {
            enable=true;
        }
        var offerRate=false;
        if($(".offer_rate").is(':checked')) {
            offerRate=true;
        }


        var isGlobalAdminCommission=$("#IsglobalAdminComission").is(":checked")? true:false;
        if(isGlobalAdminCommission==false) {
            var comission_type=$("#commission_type :selected").val();
            var admin_comission=$(".commission").val();
        } else {
            var comission_type='';
            var admin_comission='';
        }


        var adminCommission={
            'isEnabled': isGlobalAdminCommission,
            'type': comission_type,
            'amount': admin_comission
        };


        var intercityType=$(".intercity_type").is(':checked')? true:false;
        var id=database.collection("tmp").doc().id;

        if(!isEnglishNameValid) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.service_title_en_required')}}</p>");
            window.scrollTo(0,0);
        } else if(admin_comission==''&&isGlobalAdminCommission==false) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{ trans('lang.commission_help') }}</p>");
            window.scrollTo(0,0);
        } else if(kmCharge==''||kmCharge<=0) {
            $(".error_top").show();
            $(".error_top").html("");
            type=document.getElementById("distanceType").value;
            $(".error_top").append("<p>{{ trans('lang.please_enter_valid') }} "+type+
                " {{ trans('lang.charge') }}</p>");
            window.scrollTo(0,0);
        } else {
            jQuery("#overlay").show();
            storeImageData().then(IMG => {
                database.collection('service').doc(id).set({

                    'title': titles,
                    'offerRate': offerRate,
                    'kmCharge': kmCharge,
                    'image': IMG,
                    'id': id,
                    'enable': enable,
                    'intercityType': intercityType,
                    'adminCommission': adminCommission,

                }).then(function(result) {
                    jQuery("#overlay").hide();

                    window.location.href='{{ route('services') }}';

                });
            }).catch(function(error) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>"+error+"</p>");
            })
        }
    });

    var storageRef=firebase.storage().ref('images');

    async function storeImageData() {
        var newPhoto='';
        try {
            photo=photo.replace(/^data:image\/[a-z]+;base64,/,"")
            var uploadTask=await storageRef.child(fileName).putString(photo,'base64',{
                contentType: 'image/jpg'
            });
            var downloadURL=await uploadTask.ref.getDownloadURL();
            newPhoto=downloadURL;
            photo=downloadURL;
        } catch(error) {
            console.log("ERR ===",error);
        }
        return newPhoto;
    }

    function handleFileSelect(evt) {

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
                photo=filePayload;
                fileName=filename;
                $(".service_image").empty();
                $(".service_image").append(
                    '<span class="image-item" ><span class="remove-btn"><i class="fa fa-remove"></i></span><img class="rounded" style="width:50px" src="'+
                    filePayload+'" alt="image"></span>');

            };
        })(f);
        reader.readAsDataURL(f);
    }

    $(document).on('click','.remove-btn',function() {
        $(".image-item").remove();
        $('#service_image').val('');
    });
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
            content.id=`content-${language.code}`; // Ensure this matches the tab link's href
            content.role="tabpanel";
            content.innerHTML=`
            <div class="form-group row width-100">
                <label class="col-3 control-label" for="service-title-${language.code}">{{trans('lang.service_title')}} (${language.code.toUpperCase()})<span class="required-field"></span></label>
                <div class="col-7">
                    <input type="text" class="form-control" id="service-title-${language.code}">
                    <div class="form-text text-muted">{{ trans("lang.service_title_help") }}</div>
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