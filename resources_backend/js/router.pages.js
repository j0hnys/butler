
// //vvv does not work in vanilla laravel
// require('fs').readdirSync(__dirname + '/').forEach(function(file) {
//     if (file.match(/\.vue$/) !== null) {
//         var name = file.replace('.vue', '');
//         exports[name] = require('./' + file);
//     }
// });
// //^^^

//pages
exports.index = require("./pages/Index.vue").default;

exports.project_list_delete = require("./pages/project_list_delete.vue").default;
exports.project_create = require("./pages/project_create.vue").default;
exports.project_update = require("./pages/project_update.vue").default;