<?php
// Modelo Nft: consultas sobre NFTs y lógica de compra (simulada, sin blockchain)
class Nft {
    public static function findByUser($conn, $user_id) {
        $stmt = $conn->prepare('SELECT * FROM nfts WHERE owner_id = ? OR uploader_id = ? ORDER BY created_at DESC');
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function findOwnedByUser($conn, $user_id) {
        // Devuelve NFTs que actualmente pertenecen al usuario
        $stmt = $conn->prepare('SELECT * FROM nfts WHERE owner_id = ? ORDER BY created_at DESC');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function findCreatedByUser($conn, $user_id) {
        // Devuelve NFTs creados o subidos por el usuario
        $stmt = $conn->prepare('SELECT * FROM nfts WHERE creator_id = ? OR uploader_id = ? ORDER BY created_at DESC');
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($row = $res->fetch_object()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function findById($conn, $id) {
        $stmt = $conn->prepare('SELECT * FROM nfts WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_object();
    }

  
    public static function purchase($conn, $nft_id, $buyer_id) {
    // Compra simulada: decrementa supply, asigna nuevo owner e inserta transacción
        $conn->begin_transaction();
        try {
      
            $stmt = $conn->prepare('SELECT id, supply, owner_id, price, uploader_id, creator_id FROM nfts WHERE id = ? FOR UPDATE');
            $stmt->bind_param('i', $nft_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $nft = $res->fetch_object();
            if (!$nft) {
                $conn->rollback();
                return ['success'=>false, 'message'=>'NFT no encontrado.'];
            }

            if ($nft->owner_id == $buyer_id) {
                $conn->rollback();
                return ['success'=>false, 'message'=>'Ya eres el propietario de este NFT.'];
            }

            if ($nft->supply <= 0) {
                $conn->rollback();
                return ['success'=>false, 'message'=>'No hay unidades disponibles.'];
            }

            $new_supply = $nft->supply - 1;
            $is_listed = ($new_supply > 0) ? 1 : 0;
            $status = ($new_supply > 0) ? 'listed' : 'sold';

            $upd = $conn->prepare('UPDATE nfts SET supply = ?, owner_id = ?, is_listed = ?, status = ? WHERE id = ?');
            $upd->bind_param('iiisi', $new_supply, $buyer_id, $is_listed, $status, $nft_id);
            $ok = $upd->execute();
            if (!$ok) {
                $conn->rollback();
                return ['success'=>false, 'message'=>'Error al actualizar NFT.'];
            }

            $seller_id = null;
            if (!empty($nft->owner_id)) {
                $seller_id = $nft->owner_id;
            } elseif (!empty($nft->uploader_id)) {
                $seller_id = $nft->uploader_id;
            } elseif (!empty($nft->creator_id)) {
                $seller_id = $nft->creator_id;
            } else {
                $seller_id = $buyer_id;
            }
            $price = $nft->price ? $nft->price : 0.0;
            $ins = $conn->prepare('INSERT INTO transactions (nft_id, buyer_id, seller_id, price, tx_hash) VALUES (?, ?, ?, ?, NULL)');
            $ins->bind_param('iiid', $nft_id, $buyer_id, $seller_id, $price);
            $ins_ok = $ins->execute();
            if (!$ins_ok) {
                $conn->rollback();
                return ['success'=>false, 'message'=>'Error al insertar transacción.'];
            }

            $conn->commit();
            return ['success'=>true, 'message'=>'Compra realizada con éxito.'];
        } catch (Exception $e) {
            $conn->rollback();
            return ['success'=>false, 'message'=>'Excepción: ' . $e->getMessage()];
        }
    }
}
