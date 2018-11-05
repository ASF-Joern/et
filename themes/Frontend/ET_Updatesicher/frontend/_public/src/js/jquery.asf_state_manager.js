;(function($) {
    var active = true;
    var enterViewportXS = function enterViewportXS() {
        active = true;
        if(!active) {
            return;
        }

        $('#mobile-service li').each(function(i,e){if(i>1)$(this).addClass('is--hidden');});

        function rotateFirst() {

            $('#mobile-service li').each(function(i,e){
                if(i === 0) {
                    $(this).addClass('is--hidden');
                }
                if(i === 1) {
                    $(this).addClass('is--hidden');
                }
                if(i === 2) {
                    $(this).removeClass('is--hidden');
                }
                if(i === 3) {
                    $(this).removeClass('is--hidden');
                }
            });
            setTimeout(function(){rotateSecond()},2000);

        }

        function rotateSecond() {

            $('#mobile-service li').each(function(i,e){
                if(i === 2) {
                    $(this).addClass('is--hidden');
                }
                if(i === 3) {
                    $(this).addClass('is--hidden');
                }
                if(i === 4) {
                    $(this).removeClass('is--hidden');
                }
                if(i === 5) {
                    $(this).removeClass('is--hidden');
                }
            });

            setTimeout(function(){rotateThird()},3000);

        }

        function rotateThird() {
            $('#mobile-service li').each(function(i,e){if(i>1)$(this).addClass('is--hidden');});
            rotateFirst();
        }
        setTimeout(function(){rotateFirst()},2000);

    }

    var enterViewportS = function enterViewportS() {
        active = true;
        if(!active) {
            return;
        }

        $('#mobile-service li').each(function(i,e){if(i>1)$(this).addClass('is--hidden');});

        function rotateFirst() {

            $('#mobile-service li').each(function(i,e){
                if(i === 0) {
                    $(this).addClass('is--hidden');
                }
                if(i === 1) {
                    $(this).addClass('is--hidden');
                }
                if(i === 2) {
                    $(this).removeClass('is--hidden');
                }
                if(i === 3) {
                    $(this).removeClass('is--hidden');
                }
            });
            setTimeout(function(){rotateSecond()},2000);

        }

        function rotateSecond() {

            $('#mobile-service li').each(function(i,e){
                if(i === 2) {
                    $(this).addClass('is--hidden');
                }
                if(i === 3) {
                    $(this).addClass('is--hidden');
                }
                if(i === 4) {
                    $(this).removeClass('is--hidden');
                }
                if(i === 5) {
                    $(this).removeClass('is--hidden');
                }
            });

            setTimeout(function(){rotateThird()},3000);

        }
        function rotateThird() {
            $('#mobile-service li').each(function(i,e){if(i>1)$(this).addClass('is--hidden');});
            rotateFirst();
        }
        setTimeout(function(){rotateFirst()},2000);

    }
    //
    // var enterViewportM = function enterViewportM() {
    //     console.log('M Ansicht');
    // }
    //
    // var enterViewportL = function enterViewportL() {
    //     console.log('L Ansicht');
    // }
    //
    // var enterViewportXL = function enterViewportXL() {
    //     console.log('XL Ansicht');
    // }
    //
     var leaveViewportXS = function leaveViewportXS() {
         active = false;
     }

     var leaveViewportS = function leaveViewportS() {
         active = false;
     }
    //
    // var leaveViewportM = function leaveViewportM() {
    //     console.log('M Ansicht verlassen');
    // }
    //
    // var leaveViewportL = function leaveViewportL() {
    //     console.log('L Ansicht verlassen');
    // }
    //
    // var leaveViewportXL = function leaveViewportXL() {
    //     console.log('XL Ansicht verlassen');
    // }

    StateManager.registerListener([{
        state: 'xs',
        enter: enterViewportXS,
        exit: leaveViewportXS
    }]);
    StateManager.registerListener([{
        state: 's',
        enter: enterViewportS,
        exit: leaveViewportS
    }]);
    // StateManager.registerListener([{
    //     state: 'm',
    //     enter: enterViewportM,
    //     exit: leaveViewportM
    // }]);
    // StateManager.registerListener([{
    //     state: 'l',
    //     enter: enterViewportL,
    //     exit: leaveViewportL
    // }]);
    // StateManager.registerListener([{
    //     state: 'xl',
    //     enter: enterViewportXL,
    //     exit: leaveViewportXL
    // }]);

})(jQuery);
