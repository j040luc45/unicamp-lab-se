<?php

include_once("config.php");

function SQLUpdate($sql, $parans = false, $dbh = false)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;

	if (!$dbh) {
		try {
			$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
		} catch (PDOException $e) {
			die("<font color=\"red\">SQLUpdate/Delete: Erreur de connexion : " . $e->getMessage() . "</font>");
		}

		$dbh->exec("SET CHARACTER SET utf8");
		$presereveDbh = false;
	}
	else 
		$presereveDbh = true;

	if ($parans) {
		$res = $dbh->prepare($sql);
		$res->execute($parans);
	}
	else {
		$res = $dbh->query($sql);
	}

	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLUpdate/Delete: Erreur de requete : " . $e[2] . "</font>");
	}

	if (!$presereveDbh)
		$dbh = null;

	$nb = $res->rowCount();
	if ($nb != 0) return $nb;
	else return false;
	
}

// Un delete c'est comme un Update
function SQLDelete($sql, $parans = false) {
	return SQLUpdate($sql, $parans);
}

function SQLInsert($sql, $parans = false, $dbh = false)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;
	
	if (!$dbh) {
		try {
			$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
		} catch (PDOException $e) {
			die("<font color=\"red\">SQLUpdate/Delete: Erreur de connexion : " . $e->getMessage() . "</font>");
		}

		$dbh->exec("SET CHARACTER SET utf8");
		$presereveDbh = false;
	}
	else 
		$presereveDbh = true;

	if ($parans) {
		$res = $dbh->prepare($sql);
		$res->execute($parans);
	}
	else {
		$res = $dbh->query($sql);
	}

	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLInsert: Erreur de requete : " . $e[2] . "</font>");
	}

	$lastInsertId = $dbh->lastInsertId();

	if (!$presereveDbh)
		$dbh = null;

	return $lastInsertId;
}


/**
 * Effectue une requete SELECT dans une base de données SQL SERVER
 * Renvoie FALSE si pas de resultats, ou la ressource sinon
 * @pre Les variables  $BDD_login, $BDD_password $BDD_chaine doivent exister
 * @param string $SQL
 * @return boolean|resource
 */
function SQLSelect($sql, $parans = false, $dbh = false)
{	
 	global $BDD_host;
	global $BDD_base;
 	global $BDD_user;
 	global $BDD_password;

	 if (!$dbh) {
		try {
			$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
		} catch (PDOException $e) {
			die("<font color=\"red\">SQLUpdate/Delete: Erreur de connexion : " . $e->getMessage() . "</font>");
		}

		$dbh->exec("SET CHARACTER SET utf8");
		$presereveDbh = false;
	}
	else 
		$presereveDbh = true;

	$dbh->exec("SET SESSION group_concat_max_len = 1000000");
	if ($parans) {
		$res = $dbh->prepare($sql);
		$res->execute($parans);
	}
	else {
		$res = $dbh->query($sql);
	}

	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLSelect: Erreur de requete : " . $e[2] . "</font>");
	}
	
	$num = $res->rowCount();

	if (!$presereveDbh)
		$dbh = null;

	if ($num==0) return false;
	else return $res;
}

/**
* Effectue une requete SELECT dans une base de données SQL SERVER, pour récupérer uniquement un champ (la requete ne doit donc porter que sur une valeur)
* Renvoie FALSE si pas de resultats, ou la valeur du champ sinon
* @pre Les variables  $BDD_login, $BDD_password $BDD_chaine doivent exister
* @param string $SQL
* @return false|string
*/
function SQLGetChamp($sql, $parans = false, $dbh = false)
{
	global $BDD_host;
	global $BDD_base;
	global $BDD_user;
	global $BDD_password;

	if (!$dbh) {
		try {
			$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
		} catch (PDOException $e) {
			die("<font color=\"red\">SQLUpdate/Delete: Erreur de connexion : " . $e->getMessage() . "</font>");
		}

		$dbh->exec("SET CHARACTER SET utf8");
		$presereveDbh = false;
	}
	else 
		$presereveDbh = true;

	$dbh->exec("SET SESSION group_concat_max_len = 1000000");
	if ($parans) {
		$res = $dbh->prepare($sql);
		$res->execute($parans);
	}
	else {
		$res = $dbh->query($sql);
	}

	if ($res === false) {
		$e = $dbh->errorInfo(); 
		die("<font color=\"red\">SQLGetChamp: Erreur de requete : " . $e[2] . "</font>");
	}

	$num = $res->rowCount();

	if (!$presereveDbh)
		$dbh = null;

	if ($num==0) return false;
	
	$res->setFetchMode(PDO::FETCH_NUM);

	$ligne = $res->fetch();
	if ($ligne == false) return false;
	else return $ligne[0];

}

function parcoursRs($result)
{
	if  ($result == false) return array();

	$result->setFetchMode(PDO::FETCH_ASSOC);
	while ($ligne = $result->fetch()) 
		$tab[]= $ligne;

	return $tab;
}

?>