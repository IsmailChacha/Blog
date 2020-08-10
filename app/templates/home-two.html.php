<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/admin.css'; ?>">

<!-- Admin content -->
<div class="admin-content">
	<div class="content2">
		<h2 class="page-title">Dashboard</h2>
		<?php include ROOT_PATH. "/app/helpers/formerrors.php"; ?>
		<?php include ROOT_PATH. "/app/helpers/messages.php"; ?>
		
		<!-- DASHBOARD CONTENT -->
		<div class="dashboard-content">
			<h4>Posts Stats</h4>
			<table>
				<tbody>
					<tr>
						<td>All Posts<td>
						<td>Published<td>
						<td>Unpublished<td>
					</tr>
					<tr>
						<td><?php //echo $posts; ?><td>
						<td><?php //echo $published; ?><td>
						<td><?php //echo $unpublished; ?><td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //DASHBOARD CONTENT -->
	</div>
</div>
<!-- Admin content -->
