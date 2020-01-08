
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
exports.definition_list_delete = require("./pages/definition_list_delete.vue").default;
exports.definition_create = require("./pages/definition_create.vue").default;
exports.definition_update = require("./pages/definition_update.vue").default;
exports.entity_list_delete = require("./pages/entity_list_delete.vue").default;
exports.entity_create = require("./pages/entity_create.vue").default;
exports.entity_update = require("./pages/entity_update.vue").default;
exports.view_list_delete = require("./pages/view_list_delete.vue").default;
exports.view_create = require("./pages/view_create.vue").default;
exports.view_update = require("./pages/view_update.vue").default;
exports.test_list_delete = require("./pages/test_list_delete.vue").default;
exports.test_create = require("./pages/test_create.vue").default;
exports.test_update = require("./pages/test_update.vue").default;