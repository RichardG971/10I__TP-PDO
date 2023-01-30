$(document).ready(function()
{
    let navHead = $('#navHead'), navFoot = $('#navFoot');
    let main = $('main');

    let h_window, w_window, h_navHead, h_navFoot;
    let marge_nav = 16;
    
    function hNav()
    {
        h_navHead = Math.round(navHead.outerHeight() + marge_nav); // hauteur bordure et boîte en Jquery
        h_navFoot = Math.round(navFoot.outerHeight() + marge_nav);

        if((Math.round($('header').outerHeight()) != h_navHead)
            || (Math.round($('footer').outerHeight()) != h_navFoot))
        {
            $('header').css('height', h_navHead +'px');
            $('footer').css('height', h_navFoot +'px');
        }
        // console.log('taille navhead : '+ h_navHead +'\ntaille navFoot : '+ h_navFoot);
    }
    
    let posCenter_topBase, posCenter_topNew, content_comparH_posC,
    posModal_topBase, posModal_topNew, content_comparH_modal,
    h_modal, w_modal;

    function pos_centerBase()
    {
        $('.posCenter').css('position', 'relative');
        // $('.posCenter').css('transform', 'translateX(-50%)');

        if($('.posCenter')[0])
        {
            posCenter_topBase = Math.round($('.posCenter').offset().top);
        } else {
            posCenter_topBase = 0;
        }
    }
    
    function pos_center()
    {
        // if(h_window != Math.round($(window).outerHeight())) { // Pas besoin de condition, affection effectué à chaque fois que la fenêtre change avec la function '$(window).resize(function() {})'.
        h_window = Math.round($(window).outerHeight());
        // }
        
        content_comparH_posC = h_window - (posCenter_topBase + h_navFoot);
        posCenter_topNew = (content_comparH_posC - Math.round($('.posCenter').outerHeight())) / 2;

        if($('.posCenter').outerHeight() < content_comparH_posC )
        {
            $('.posCenter').css('top', posCenter_topNew +'px');
        } else {
            $('.posCenter').css('top', '');
        }
    }
    
    function pos_modalBase()
    {
        $('.modalRes').css('position', 'relative');
        $('.modalRes').css('transform', 'translateX(-50%)');
        $('.modalRes').css('top', (h_navHead - marge_nav) +'px');

        posModal_topBase = h_navHead - marge_nav;
    }
    
    function pos_modal()
    {
        // 'h_window' déjà calculé dans 'pos_center()'.
        w_modal = Math.round($('.modalRes').outerWidth());
        h_modal = Math.round($('.modalRes').outerHeight());
        $('.modalRes').css('left', (w_modal / 2) +'px');

        content_comparH_modal = h_window - (h_navHead + h_navFoot - marge_nav*2);
        posModal_topNew = (content_comparH_modal - h_modal) / 2 + posModal_topBase;

        if($('.formRes')[0] || $('.formResFinal')[0])
        {
            // $('.modalBgc').css('visibility', 'visible'); // Créer dans le CSS. Comme cela si JavaScript est désactivé,
            //                                              // le modal s'affichera quand même grace au class 'formRes' ou 'formResFinal' intégré avec php.
            $('body').css('overflow-y', 'hidden');
            $('main').css('overflow', 'hidden');

            if($('.modalRes').outerHeight() < content_comparH_modal )
            {
                $('.modalBgc').css('position', 'fixed');
                $('.modalBgc').css('height', '100%');
                $('.modalRes').css('top', posModal_topNew +'px');
                $('main').css('max-height', (content_comparH_modal - marge_nav*2) +'px'); // Retrait des marges car 'main' est positionné entre les barres de navigation qui ont une marge.
                $('.modalRes').css('max-height', 'initial');
            } else {
                $('.modalBgc').css('position', 'absolute');  // Manipulation nécessaire si la hauteur de la fenêtre est trop petite.
                                                                // En position fixed on ne peut pas scroller pour voir le reste du contenu.
                $('.modalBgc').css('height', (h_navHead + h_navFoot - marge_nav*2 + h_modal) +'px');
                $('.modalRes').css('top', posModal_topBase +'px');
                $('main').css('max-height', (h_modal - (h_navFoot + marge_nav*2)) +'px');
                $('.modalRes').css('max-height', (content_comparH_modal + h_navFoot - marge_nav) +'px');
            }
        }
    }
    
    function modalClose()
    {
        if($('.formRes')[0] || $('.formResFinal')[0])
        {
            // $('.modalBgc').css('visibility', 'hidden'); // Affectation grâce au CSS.
            $('.modalBgc').removeClass('formRes');
            $('.modalBgc').removeClass('formResFinal');
            $('main').css('max-height', 'initial');
            $('body').css('overflow-y', 'initial');
            $('main').css('overflow', 'initial');
        }/*  else if($('.formResFinal')[0]) {
            adUrl = window.location.href;
            adUrlSearch = adUrl.slice(adUrl.lastIndexOf('index.php?'));
            window.location.href = adUrl.replace(adUrlSearch, 'index.php');
        } */
    }

    $('.modalBgc').click(function(e)
    {
        if($('.formRes')[0])
        {
            if(!$(e.target).closest('.modalRes').length)
            {
                modalClose();
            }
        } else if($('.formResFinal')[0]) {
            if(!$(e.target).closest('.modalRes').length)
            {
                modalClose();
            }
        }
    });

    $('.btnModalClose').click(function()
    {
        modalClose();
    });

    // 'keyup' évènement quand on appuie sur la touche.
    //    'which' permet de récupérer la valeur de la touche appuyé. '27' est la valeur 'keyup' de la touche échap.
    // Fonction permettant de fermer le modal avec la touche échap.
    $(window).keyup(function(event)
    {
        if(($('.formRes')[0] || $('.formResFinal')[0]) && event.which === 27)
        {
            modalClose();
        }
    });
    
    hNav(), pos_centerBase(), pos_center(), pos_modalBase(), pos_modal();
    
    $(window).resize(function() {
        hNav();
        pos_center();
        pos_modal();
    });


    let today = new Date;

    function dateFormat(D)
    {
        d = new Date(D),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
    
    // function dateAffect(D, nbJ, signe)
    //    D = la date concernée.
    //    nbJ = nombre de jour à affecter à la date 'D'.
    //    signe =  '-1' pour soustraire, '1' pour ajouter.
    function dateAffect(D, nbJ, signe)
    {
        d = new Date(D);
        d.setDate(d.getDate()+ nbJ * signe);
        d = dateFormat(d);

        return d;
    }

    // Fonction pour donner les valeurs minimum et maximum autoriées lors de la réservation du client.
    function affectDateReserv()
    {
        let dateArr = $('#dateArr')[0].value;

        if($('#dateArr')[0].value != '')
        {
            if($('#dateArr')[0].value < dateFormat(today))
            {
                dateArr = $('#dateArr')[0].value = dateFormat(today);
            }
            $('#dateDep').prop('min', dateAffect(dateArr, 1, 1));
            $('#dateDep').prop('max', dateAffect(dateArr, 28, 1));

            if($('#role')[0] && $('#role')[0].innerText == '1')
            {
                $('#dateDep').prop('max', '');
            }
            if($('#dateDep')[0].value != '')
            {
                if($('#dateDep')[0].value < $('#dateDep').prop('min'))
                {
                    $('#dateDep')[0].value = $('#dateDep').prop('min');
                } else if(($('#dateDep').prop('max') != '') && ($('#dateDep')[0].value > $('#dateDep').prop('max'))) {
                    $('#dateDep')[0].value = $('#dateDep').prop('max');
                }
            }
        } else if($('#dateDep')[0].value != '' && $('#dateDep')[0].value < dateAffect(today, 1, 1)) {
            $('#dateArr')[0].value = dateFormat(today);
            $('#dateDep')[0].value = dateAffect(today, 1, 1);
            $('#dateDep').prop('min', dateAffect(today, 1, 1));
            $('#dateDep').prop('max', dateAffect(today, 28, 1));
            
            if($('#role')[0] && $('#role')[0].innerText == '1')
            {
                $('#dateDep').prop('max', '');
            }
        } else {
            $('#dateDep').prop('min', '');
            $('#dateDep').prop('max', '');
        }
    }
        
    function affectDateResEdit()
    {
        let dateArr = $('#dateArr')[0].value;
        let dateDep = $('#dateDep')[0].value;

        if($('#dateArr')[0].value < dateFormat(today))
        {
            $('#dateArr').prop('min', dateArr);
            $('#dateArr').prop('max', dateArr);
            
            if($('#role')[0] && $('#role')[0].innerText == '1')
            {
                $('#dateDep').prop('min', dateFormat(today));
                $('#dateDep').prop('max', '');
            } else {
                $('#dateDep').prop('min', dateDep);
                $('#dateDep').prop('max', dateAffect(dateArr, 28, 1));
            }
        } else {
            if($('#role')[0] && $('#role')[0].innerText == '1') {
                $('#dateArr').prop('min', dateFormat(today));
                $('#dateDep').prop('min', dateAffect(dateArr, 1, 1));
                $('#dateDep').prop('max', '');
                $('#dateArr').blur(function() {
                    $('#dateDep').prop('min', dateAffect($('#dateArr')[0].value, 1, 1));
                });
            } else {
                $('#dateArr').prop('min', dateArr);
                $('#dateArr').prop('max', dateArr);
                $('#dateDep').prop('min', dateDep);
                $('#dateDep').prop('max', dateAffect(dateArr, 28, 1));
            }
        }
    }
    
    function affectDateArrSearch()
    {
        if($('#dateArrSearch')[0].value === '' && $('#dateDepSearch')[0].value !== '')
        {
            let dateArrSearch = $('#dateArrSearch')[0];
            let dateDepSearch = dateFormat($('#dateDepSearch')[0].value);
            if(dateDepSearch > dateAffect(today, 7, 1))
            {
                $('#dateArrSearch')[0].value = dateFormat(today);
            } else {
                dateArrSearch.value = dateAffect(dateDepSearch, 7, -1);
            }
        }
    }
    
    function affectOccupationSearch()
    {
        if(($('#dateArrSearch')[0].value !== '' && $('#dateDepSearch')[0].value === '')
            || ($('#dateArrSearch')[0].value === '' && $('#dateDepSearch')[0].value !== ''))
        {
            $('#occupation')[0].value = 'libre(s)';
        }
    }

    function prixJours(dArr, dDep)
    {
        dArr = new Date(dArr), dDep = new Date(dDep); // Récupération des dates.
        nbJ = dDep - dArr; // Calcul de la durée du séjour.
        nbJ = nbJ / 1000 / 60 / 60 / 24; // Conversion en nombre de jour.
        prix = $('#prix')[0].childNodes[0].nodeValue; // Récupérer la valeur du prix.
        return nbJ +' nuit(s)<br>'+ (nbJ * prix) +' €';
    }

    function affectPrix()
    {
        if($('#dateArr')[0].value != '' && $('#dateDep')[0].value != '')
        {
            dateArr = $('#dateArr')[0].value;
            dateDep = $('#dateDep')[0].value;
            prixTotal = prixJours(dateArr, dateDep);
            $('.prixTotal').html(prixTotal);
        } else {
            $('.prixTotal').html('0 €');
        }
    }

    function affectPrixAll()
    {
        affectPrix();

        $('#dateDep').blur(function()
        {
            affectPrix();
        });

        $('#dateArr').blur(function()
        {
            affectPrix();
        });
    }
    
    // Fonctions à appliquer selon l'url.
    // console.log(window.location.search);
    if(window.location.search.includes("action=reservation&chambre")) {
        console.log("action=reservation&chambre");
        $('#dateArr').blur(function()
        {
            affectDateReserv();
        });
        
        $('#dateDep').blur(function()
        {
            affectDateReserv();
        });

        affectPrixAll();
    } else if(window.location.search.includes("action=upd_reserv&client")) {
        console.log("action=upd_reserv&client");
        affectDateResEdit();

        affectPrixAll();
    } else if(window.location.search.includes("action=list_chambre")) {
        console.log("action=list_chambre");
        $('#dateArrSearch').blur(function()
        {
            affectOccupationSearch();
        });

        $('#dateDepSearch').blur(function()
        {
            affectOccupationSearch();
            affectDateArrSearch();
        });
    }
});