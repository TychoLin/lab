<?php
$pdo = DB::getPDO("drlight");
$notorm_db = new NotORM($pdo);

$actions = array("list", "create", "edit");
$action = "list";
if (isset($_GET["action"]) && in_array($_GET["action"], $actions)) {
	$action = $_GET["action"];
}
?>
<style type="text/css">
.col-head {
	float: left;
	display: inline-block;
	text-align: right;
	margin-right: 1em;
}

.group {
	margin-bottom: 0.5em;
}

.group:after {
	content: "";
	display: table;
	clear: both;
}

.col {
	width: 80%;
	float: left;
}
</style>
<?php if ($action == "list") { ?>
<table>
	<tr>
		<th width="60%">標題</th>
		<th>日期</th>
		<th></th>
	</tr>
	<?php foreach ($notorm_db->article() as $article) { ?>
	<tr>
		<td><?php echo $article["title"]; ?></td>
		<td><?php echo $article["create_time"]; ?></td>
		<td><a href="?v=article&action=edit">edit</a></td>
	</tr>
	<?php } ?>
</table>
<?php } else if ($action == "create") { ?>
<h3>新增文章</h3>
<form action="<?php echo SELF_URL; ?>" method="post">
	<div class="group">
		<label class="col-head">標題</label>
		<div class="col">
			<input name="title" type="text" size="64" autofocus>
		</div>
	</div>
	<div class="group">
		<label class="col-head">內容</label>
		<div class="col">
			<div id="trumbowyg-demo"></div>
		</div>
	</div>
	<button type="submit">送出</button>
</form>
<script src="trumbowyg/1.1.4/dist/trumbowyg.min.js"></script>
<script src="trumbowyg/1.1.4/dist/plugins/upload/trumbowyg.upload.js"></script>
<link rel="stylesheet" href="trumbowyg/1.1.4/dist/ui/trumbowyg.min.css">
<script type="text/javascript">
$(function () {
	var btnsGrps = jQuery.trumbowyg.btnsGrps;
	$("#trumbowyg-demo").trumbowyg({
		btnsDef: {
			image: {
				dropdown: ['insertImage', 'upload'],
				ico: 'insertImage'
			}
		},
		btns: ['viewHTML',
			'|', 'formatting',
			'|', btnsGrps.design,
			'|', 'link',
			'|', 'image',
			'|', btnsGrps.justify,
			'|', btnsGrps.lists,
			'|', 'horizontalRule']
	});
});
</script>
<?php } else if ($action == "edit") { ?>
<h3>編輯文章</h3>
<form action="<?php echo SELF_URL; ?>" method="post">
	<div class="group">
		<label class="col-head">標題</label>
		<div class="col">
			<input name="title" type="text" size="64" autofocus>
		</div>
	</div>
	<div class="group">
		<label class="col-head">內容</label>
		<div class="col">
			<div id="trumbowyg-demo"></div>
		</div>
	</div>
	<button type="submit">送出</button>
</form>
<script src="trumbowyg/1.1.4/dist/trumbowyg.min.js"></script>
<link rel="stylesheet" href="trumbowyg/1.1.4/dist/ui/trumbowyg.min.css">
<script type="text/javascript">
</script>
<?php } ?>
