var checkingSessionObj = null;
var countDownLogoutObj = null;
var timeToCountDown = 60;
$(document).ready(function () {
    $(document).on('click', '#logoutCountDown_Yes', function () {
        //alert('YES');
        extendSession();
        return false;
    });
    $(document).on('click', '#logoutCountDown_No', function () {
        //alert('NO');
        sessionLogout();
        return false;
    });
    $(document).on('click', '#logoutCountDown_Close', function () {
        $("#popup_logoutCountDown").modal('hide');
        extendSession();
    });
    startCountDown(SessionExprieIn);
    //$('body').toggleClass('loaded');
});

function startCountDown(SessionExprieTime) {
    var timeToShow = SessionExprieTime - timeToCountDown;
    if (SessionExprieTime != '' && SessionExprieTime > 0) {
        if (checkingSessionObj && checkingSessionObj != null) {
            checkingSessionObj.stop();
        }
        if (countDownLogoutObj && countDownLogoutObj != null) {
            countDownLogoutObj.stop();
        }

        checkingSessionObj = Tock({
            countdown: true,
            interval: 500,
            callback: function () {
                var checkinRemainTime = checkingSessionObj.lap() / 1000;
                //var minutes = Math.ceil (checkinRemainTime/(60));
                //var seconds = Math.ceil (checkinRemainTime);
                //console.log('checking',seconds);
            },
            complete: function () {
                validateSessionExprie(function (response) {
                    if (response.SessionExprieIn <= timeToCountDown) {
                        if ($('#popup_logoutCountDown').css('display') == 'none') {
                            $("#popup_logoutCountDown").modal('show');
                        }
                        countDownLogoutObj.start(response.SessionExprieIn * 1000);
                    } else {
                        startCountDown(response.SessionExprieIn);
                    }
                });
            }
        });

        countDownLogoutObj = Tock({
            countdown: true,
            interval: 500,
            callback: function () {
                var checkinRemainTime = countDownLogoutObj.lap() / 1000;
                //var minutes = Math.ceil (checkinRemainTime/(60));
                var seconds = Math.ceil(checkinRemainTime);
                //console.log(countDownLogoutObj.lap() / 1000,seconds);
                //console.log('countDown',seconds);
                var label = seconds > 1 ? 'seconds' : 'second';
                label = seconds + ' ' + label;
                $('#logoutCountDownLabel').html(label);
            },
            complete: function () {
                validateSessionExprie(function (response) {
                    if (response.SessionExprieIn <= 0) {
                        sessionLogout();
                    } else {
                        startCountDown(response.SessionExprieIn);
                    }
                });

            }
        });
        checkingSessionObj.start(timeToShow * 1000);
    }
}

function extendSession() {
    var params = '';
    $.ajax({
        url: window_app.webroot_admin + 'Users/extendSession.json',
        type: 'GET',
        data: params
    })
        .done(function (response) {
            SessionExprieIn = response.SessionExprieIn;
            startCountDown(SessionExprieIn);
            $("#popup_logoutCountDown").modal('hide');
        })
        .fail(function () {
        });
}

function sessionLogout() {
    var params = '';
    $.ajax({
        url: window_app.webroot_admin + 'Users/sessionLogout.json',
        type: 'GET',
        data: params
    })
        .done(function (response) {
            if (response.status == 'ok') {
                $("#popup_logoutCountDown").modal('hide');
                window.location.reload();
            }
        })
        .fail(function () {
        });

}

function validateSessionExprie(callBackAction) {
    var params = '';
    $.ajax({
        url: window_app.webroot_admin + 'Users/validateSessionExprie.json',
        type: 'GET',
        data: params
    })
        .done(function (response) {
            if (typeof (callBackAction) == 'function') {
                callBackAction(response);
            }
        })
        .fail(function () {
        });

}

if ($('.statistic').length) {
    gapi.analytics.ready(function () {

        //INITIALIZE
        gapi.analytics.auth.authorize({
            container: 'embed-api-auth-container',
            clientid: '1065108283530-obqc91nkcsnnbcbovma5g2gdi5ppkro3.apps.googleusercontent.com'
        });

        var viewSelector = new gapi.analytics.ViewSelector({
            container: 'view-selector-container'
        });

        // Render the view selector to the page.
        viewSelector.execute();


        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //USERS & SESSIONS REPORT
        var users_sessions_info_report = new gapi.analytics.report.Data({
            query: {
                metrics: 'ga:users, ga:sessions, ga:pageviews, ga:sessionsPerUser, ga:pageviewsPerSession, ga:avgSessionDuration, ga:bounceRate',
                dimensions: 'ga:date',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
        });

        users_sessions_info_report.on('success', function (response) {
            if (response.totalResults >= 1) {
                $('#total_users').text(response['totalsForAllResults']['ga:users']);
                $('#total_sessions').text(response['totalsForAllResults']['ga:sessions']);
                $('#total_pageviews').text(response['totalsForAllResults']['ga:pageviews']);
                $('#sessionsperuser').text(parseFloat(response['totalsForAllResults']['ga:sessionsPerUser']).toFixed(2));
                $('#pageviewspersessions').text(parseFloat(response['totalsForAllResults']['ga:pageviewsPerSession']).toFixed(2));
                $('#avgtimepersession').text(parseFloat(response['totalsForAllResults']['ga:avgSessionDuration']).toFixed(2) + 's');
                $('#bouncerate').text(parseFloat(response['totalsForAllResults']['ga:bounceRate']).toFixed(2));
            } else {

            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //NEW VS RETURNING USER CHART
        var new_vs_returning_users_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:sessions',
                dimensions: 'ga:userType',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'new-vs-returning-user-chart-container',
                type: 'PIE',
                options: {
                    title: 'Tỉ lệ khách mới và khách quay lại',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //CITY CHART
        var city_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users, ga:sessions',
                dimensions: 'ga:city',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'city-chart-container',
                type: 'BAR',
                options: {
                    title: 'Nơi truy cập trang (Thành phố)',
                    width: '100%'
                }
            }
        });
        //END

        //COUNTRY CHART
        var country_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users',
                dimensions: 'ga:country',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'country-chart-container',
                type: 'BAR',
                options: {
                    title: 'Nơi truy cập trang (Quốc gia)',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //USERS GROWTH
        var users_growth_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users, ga:pageviews, ga:uniquePageviews',
                dimensions: 'ga:date',
                'start-date': '30daysAgo',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'users-growth-chart-container',
                type: 'COLUMN',
                options: {
                    title: 'Sự tăng trưởng người dùng trong 30 ngày vừa qua',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //DEVICES CHART
        var devices_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users',
                dimensions: 'ga:deviceCategory',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'devices-chart-container',
                type: 'PIE',
                options: {
                    title: 'So sánh tỉ lệ các thiết bị truy cập',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //BROWSER OS CHART
        var browser_os_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users',
                dimensions: 'ga:browser, ga:operatingSystem',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'browser-chart-container',
                type: 'TABLE',
                options: {
                    title: 'Thông tin các trình duyệt, hệ điều hành và nhãn hiệu điện thoại được sử dụng để truy cập vào trang',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //AGES CHART
        var ages_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users',
                dimensions: 'ga:userAgeBracket',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'ages-chart-container',
                type: 'PIE',
                options: {
                    title: 'Độ tuổi khách truy cập',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //GENDER CHART
        var genders_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:users',
                dimensions: 'ga:userGender',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'genders-chart-container',
                type: 'PIE',
                options: {
                    title: 'Giới tính khách truy cập',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //MOSTVIEWED PAGES CHART
        var mostviewed_pages_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:pageviews,ga:uniquePageviews,ga:timeOnPage,ga:entrances,ga:exits',
                dimensions: 'ga:pagePath, ga:pageTitle',
                'max-results': 10,
                sort: '-ga:pageviews',
                'start-date': '30daysAgo',
                'end-date': 'yesterday',
                filters: 'ga:pageTitle!@NIVEA VN;ga:pagePath!@fbclid;ga:pagePath!@tim-kiem',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'mostviewed-pages-chart-container',
                type: 'TABLE',
                options: {
                    title: 'Các trang được xem nhiều nhất',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        //MOSTVIEWED PAGES CHART
        var mostsearch_keyword_chart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:totalEvents',
                dimensions: 'ga:eventCategory, ga:eventLabel',
                'max-results': 10,
                sort: '-ga:totalEvents',
                'start-date': '2019-01-01',
                'end-date': 'yesterday',
                filters: 'ga:eventLabel!@<;ga:eventLabel!@bê đê;ga:eventLabel!@(;ga:eventLabel!@*;ga:eventLabel!@dung dịch vệ sinh;ga:eventCategory=@Keyword',
                ids: 'ga:197917231'
            },
            chart: {
                container: 'mostsearch-keyword-chart-container',
                type: 'TABLE',
                options: {
                    title: 'Các từ khóa được tìm kiếm nhiều nhất',
                    width: '100%'
                }
            }
        });
        //END

        //--------------------------------------------------------------------------------------------------------------------------------------------------------

        /**
         * Render the dataChart on the page whenever a new view is selected.
         */
        viewSelector.on('change', function (ids) {
            new_vs_returning_users_chart.set({query: {ids: ids}}).execute();
            city_chart.set({query: {ids: ids}}).execute();
            country_chart.set({query: {ids: ids}}).execute();
            users_growth_chart.set({query: {ids: ids}}).execute();
            devices_chart.set({query: {ids: ids}}).execute();
            browser_os_chart.set({query: {ids: ids}}).execute();
            ages_chart.set({query: {ids: ids}}).execute();
            genders_chart.set({query: {ids: ids}}).execute();
            mostviewed_pages_chart.set({query: {ids: ids}}).execute();
            mostsearch_keyword_chart.set({query: {ids: ids}}).execute();


            //REPORT
            users_sessions_info_report.execute();
        });
    });
}