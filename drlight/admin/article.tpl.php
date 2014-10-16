<?php
$pdo = DB::getPDO("drlight");
$notorm_db = new NotORM($pdo);

$actions = array("list", "create", "edit", "delete");
$action = "list";
if (isset($_GET["action"]) && in_array($_GET["action"], $actions)) {
	$action = $_GET["action"];
}

if (count($_POST) > 0) {
	if ($action == "create") {
		$filtered_fields = array("title", "content");
		$post_data = array_intersect_key($_POST, array_fill_keys($filtered_fields, null));
		if (count($post_data) == count($filtered_fields)) {
			$notorm_db->article()->insert(array(
				"title" => $post_data["title"],
				"content" => $post_data["content"],
				"create_time" => new NotORM_Literal("NOW()"),
				"update_time" => new NotORM_Literal("NOW()"),
			));
		}
	} else if ($action == "edit") {
		//
	} else if ($action == "delete" && isset($_POST["id"])) {
		$notorm_db->article()->where("id", $_POST["id"])->delete();
	}
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
<?php if (in_array($action, array("list", "delete"))) { ?>
<table>
	<tr>
		<th width="5%"></th>
		<th width="60%">標題</th>
		<th>日期</th>
		<th></th>
	</tr>
	<?php foreach ($notorm_db->article() as $article) { ?>
	<tr>
		<td><button type="button" data-id="<?php echo $article["id"]; ?>">X</button></td>
		<td><?php echo $article["title"]; ?></td>
		<td><?php echo $article["create_time"]; ?></td>
		<td><a href="?v=article&action=edit&id=<?php echo $article["id"]; ?>">編輯</a></td>
	</tr>
	<?php } ?>
</table>
<script type="text/javascript">
$(function () {
	$("table td button[data-id]").on("click", function (event) {
		if (!window.confirm("確定刪除?")) {
			return;
		}

		$("<form>")
		.prop({action: "<?php echo SELF_URL."&action=delete"; ?>", method: "post"})
		.append($("<input>").prop({type: "hidden", name: "id", value: $(this).data("id")}))
		.submit();
	});
});
</script>
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
			<div id="content"></div>
		</div>
	</div>
	<button type="submit">送出</button>
</form>
<script type="text/javascript">

</script>
<?php } else if ($action == "edit") { ?>
<h3>編輯文章</h3>
<form action="<?php echo SELF_URL; ?>" method="post">
	<?php
	$article = $notorm_db->article()->fetch();
	?>
	<div class="group">
		<label class="col-head">標題</label>
		<div class="col">
			<input name="title" type="text" size="64" value="<?php echo $article["title"]; ?>" autofocus>
		</div>
	</div>
	<div class="group">
		<label class="col-head">內容</label>
		<div class="col">
			<div id="content"><?php echo $article["content"]; ?></div>
		</div>
	</div>
	<button type="submit">送出</button>
</form>
<script type="text/javascript">
</script>
<?php } ?>
<?php if (in_array($action, array("create", "edit"))) { ?>
<script src="trumbowyg/1.1.4/dist/trumbowyg.min.js"></script>
<script src="trumbowyg/1.1.4/dist/plugins/upload/trumbowyg.upload.js"></script>
<link rel="stylesheet" href="trumbowyg/1.1.4/dist/ui/trumbowyg.min.css">
<script type="text/javascript">
$(function () {
	var btnsGrps = jQuery.trumbowyg.btnsGrps;
	$("#content").trumbowyg({
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
<?php } ?>