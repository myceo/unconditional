"use strict";
$('.date').pickadate({
    format: 'yyyy-mm-dd',
    selectMonths: true,
    selectYears: 100,
    min: [1900,1,1],
    max: new Date(),
});
