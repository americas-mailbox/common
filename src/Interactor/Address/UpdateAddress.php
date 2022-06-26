<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Entity\Address;
use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;

final class UpdateAddress implements DbalConnection
{
  use DbalConnectionTrait;

  public function update(Address $address)
  {
    $data = [
        'addressee' => $address->getAddressee(),
        'address' => $address->getAddress(),
        'suite' => $address->getSuite(),
        'street_3' => $address->getLocationName(),
        'city' => $address->getCity(),
        'state' => $address->getState(),
        'country' => $address->getCountry(),
        'post_code' => $address->getPostCode()
    ];

    $response = $this->connection->update('addresses', $data, ['id' => $address->getId()]);
    if (1 !== $response) {
      return;
    }
    return (int)$address->getId();
  }

  public function hideUnhide(Address $address)
  {
    $data = [
      'deleted' => $address->getDeleted()
    ];
    $response = $this->connection->update('addresses', $data, ['id' => $address->getId()]);
    if (1 !== $response) {
      return;
    }
    return (int)$address->getId();
  }
}
